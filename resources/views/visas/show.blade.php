@extends('layouts.app')

@section('content')

@php
    $expiration = \Carbon\Carbon::parse($visa->date_expiration);
    $estExpire = $expiration->isPast();
    $expireBientot = !$estExpire && $expiration->diffInDays(now()) <= 7;
@endphp

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-id-card me-2" style="color:var(--dgm-gold);"></i>Fiche de séjour</h1>
        <p>Détails complets du ressortissant — Passeport : <strong>{{ $visa->numero_passeport }}</strong></p>
    </div>
    <a href="{{ route('visas.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="row g-4">
    {{-- Carte principale --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header dgm-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user me-2"></i>Informations du ressortissant</span>
                @if($estExpire)
                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Séjour expiré</span>
                @elseif($expireBientot)
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Expire bientôt</span>
                @else
                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Séjour valide</span>
                @endif
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Nom complet</div>
                            <div class="fw-bold" style="font-size:1.1rem;">{{ $visa->nom_etranger }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Numéro de passeport</div>
                            <div class="fw-bold" style="font-family:monospace; font-size:1rem; color:var(--dgm-blue);">{{ $visa->numero_passeport }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Nationalité</div>
                            <div class="fw-semibold">
                                <i class="fas fa-globe-africa me-1 text-muted"></i>{{ $visa->country->nom_pays ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Type de visa</div>
                            <span class="badge bg-light text-dark border">{{ $visa->type_visa }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Date d'entrée en RDC</div>
                            <div class="fw-semibold"><i class="fas fa-calendar-check me-1 text-success"></i>{{ \Carbon\Carbon::parse($visa->date_entree)->format('d/m/Y') }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Date d'expiration</div>
                            <div class="fw-semibold {{ $estExpire ? 'text-danger' : ($expireBientot ? 'text-warning' : 'text-success') }}">
                                <i class="fas fa-calendar-times me-1"></i>{{ $expiration->format('d/m/Y') }}
                                @if(!$estExpire)
                                    <small class="text-muted fw-normal">(dans {{ $expiration->diffInDays(now()) }} jours)</small>
                                @else
                                    <small class="fw-normal">(expiré depuis {{ now()->diffInDays($expiration) }} jours)</small>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Email de contact</div>
                            <div class="fw-semibold"><i class="fas fa-envelope me-1 text-primary"></i>{{ $visa->email_contact }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px; font-weight:600;">Téléphone</div>
                            <div class="fw-semibold"><i class="fas fa-phone me-1 text-success"></i>{{ $visa->telephone_contact }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header dgm-header-gold">
                <i class="fas fa-bolt me-2"></i>Actions disponibles
            </div>
            <div class="card-body p-3">
                <a href="{{ route('visas.avertissement', $visa->id) }}"
                   class="btn btn-warning w-100 mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-bell"></i>
                    <div class="text-start">
                        <div class="fw-bold" style="font-size:0.85rem;">Envoyer une alerte</div>
                        <div style="font-size:0.75rem; opacity:0.8;">Notifier par email</div>
                    </div>
                </a>
                <a href="{{ route('visas.index') }}"
                   class="btn btn-outline-secondary w-100 d-flex align-items-center gap-2">
                    <i class="fas fa-list"></i>
                    <span style="font-size:0.85rem;">Retour au registre</span>
                </a>
            </div>
        </div>

        {{-- Historique des alertes --}}
        @if($visa->notifications->count() > 0)
        <div class="card mt-3">
            <div class="card-header" style="background:#f8f9fa; font-size:0.85rem; font-weight:600;">
                <i class="fas fa-history me-2 text-muted"></i>Alertes envoyées ({{ $visa->notifications->count() }})
            </div>
            <div class="list-group list-group-flush">
                @foreach($visa->notifications->take(5) as $notif)
                <div class="list-group-item py-2 px-3">
                    <div class="d-flex justify-content-between">
                        <span class="badge bg-success" style="font-size:0.7rem;">{{ $notif->type_alerte }}</span>
                        <span class="text-muted" style="font-size:0.72rem;">{{ \Carbon\Carbon::parse($notif->date_envoi)->format('d/m/Y') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
