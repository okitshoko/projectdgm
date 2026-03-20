@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-passport me-2" style="color:var(--dgm-gold);"></i>Registre des séjours</h1>
        <p>Liste complète des ressortissants étrangers enregistrés</p>
    </div>
    <a href="{{ route('visas.create') }}" class="btn btn-dgm-gold">
        <i class="fas fa-plus-circle me-1"></i> Nouvel enregistrement
    </a>
</div>

<div class="card">
    <div class="card-header dgm-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i>Liste des séjours en cours</span>
        <span class="badge bg-light text-dark">{{ $visas->count() }} enregistrement(s)</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Passeport</th>
                        <th>Nom de l'étranger</th>
                        <th>Nationalité</th>
                        <th>Type de visa</th>
                        <th>Date d'expiration</th>
                        <th>Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visas as $visa)
                        @php
                            $expiration = \Carbon\Carbon::parse($visa->date_expiration);
                            $estExpire = $expiration->isPast();
                            $expireBientot = !$estExpire && $expiration->diffInDays(now()) <= 7;
                        @endphp
                        <tr>
                            <td class="text-muted" style="font-size:0.82rem;">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-bold" style="color:var(--dgm-blue); font-family:monospace; font-size:0.9rem;">
                                    {{ $visa->numero_passeport }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:32px; height:32px; background:rgba(0,48,135,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas fa-user text-primary" style="font-size:0.75rem;"></i>
                                    </div>
                                    <span class="fw-semibold" style="font-size:0.9rem;">{{ $visa->nom_etranger }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(0,48,135,0.1); color:var(--dgm-blue); font-weight:500;">
                                    <i class="fas fa-globe-africa me-1"></i>{{ $visa->country->nom_pays ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border" style="font-size:0.78rem;">{{ $visa->type_visa }}</span>
                            </td>
                            <td style="font-size:0.88rem;">
                                <i class="fas fa-calendar me-1 text-muted"></i>{{ $expiration->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($estExpire)
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Expiré</span>
                                @elseif($expireBientot)
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Expire bientôt</span>
                                @else
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Valide</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('visas.show', $visa->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Voir les détails"
                                       style="border-radius:6px; padding:4px 10px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('visas.avertissement', $visa->id) }}"
                                       class="btn btn-sm btn-outline-warning" title="Envoyer une alerte"
                                       style="border-radius:6px; padding:4px 10px;">
                                        <i class="fas fa-bell"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-2">Aucun séjour enregistré pour le moment.</p>
                                <a href="{{ route('visas.create') }}" class="btn btn-dgm btn-sm">
                                    <i class="fas fa-plus me-1"></i> Enregistrer le premier séjour
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
