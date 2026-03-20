@extends('layouts.app')

@section('content')

{{-- En-tête de page --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-tachometer-alt me-2" style="color:var(--dgm-gold);"></i>Accueil</h1>
        <p>Vue d'ensemble des séjours et alertes — {{ now()->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('visas.create') }}" class="btn btn-dgm-gold">
        <i class="fas fa-plus-circle me-1"></i> Nouveau séjour
    </a>
</div>

{{-- Statistiques --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #003087, #1a4a9e);">
            <div class="stat-label">Total des séjours enregistrés</div>
            <div class="stat-value">{{ $totalVisas }}</div>
            <i class="fas fa-passport stat-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #8B6914, #C8A951);">
            <div class="stat-label">Expirations dans 7 jours</div>
            <div class="stat-value">{{ $expiresBientot }}</div>
            <i class="fas fa-clock stat-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #8B0000, #dc3545);">
            <div class="stat-label">Séjours expirés</div>
            <div class="stat-value">{{ $expires }}</div>
            <i class="fas fa-exclamation-triangle stat-icon"></i>
        </div>
    </div>
</div>

{{-- Actions et infos --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header dgm-header">
                <i class="fas fa-cogs me-2"></i>Actions de gestion
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('visas.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                    <div style="width:36px; height:36px; background:rgba(0,48,135,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center;" class="me-3">
                        <i class="fas fa-list text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;">Registre des séjours</div>
                        <div class="text-muted" style="font-size:0.78rem;">Consulter et gérer tous les séjours</div>
                    </div>
                    <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                </a>
                <a href="{{ route('visas.create') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                    <div style="width:36px; height:36px; background:rgba(200,169,81,0.15); border-radius:8px; display:flex; align-items:center; justify-content:center;" class="me-3">
                        <i class="fas fa-plus-circle" style="color:var(--dgm-gold);"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;">Enregistrer un séjour</div>
                        <div class="text-muted" style="font-size:0.78rem;">Ajouter un nouveau ressortissant étranger</div>
                    </div>
                    <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                </a>
                <a href="{{ route('countries.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                    <div style="width:36px; height:36px; background:rgba(25,135,84,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center;" class="me-3">
                        <i class="fas fa-globe-africa text-success"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;">Gestion des pays</div>
                        <div class="text-muted" style="font-size:0.78rem;">Gérer les nationalités et pays de provenance</div>
                    </div>
                    <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                </a>
                <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                    <div style="width:36px; height:36px; background:rgba(255,193,7,0.15); border-radius:8px; display:flex; align-items:center; justify-content:center;" class="me-3">
                        <i class="fas fa-bell text-warning"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.9rem;">Historique des alertes</div>
                        <div class="text-muted" style="font-size:0.78rem;">Voir toutes les notifications envoyées</div>
                    </div>
                    <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header dgm-header-gold">
                <i class="fas fa-info-circle me-2"></i>Informations système
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start gap-3 mb-4">
                    <div style="width:42px; height:42px; background:rgba(0,48,135,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fas fa-robot text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-semibold mb-1" style="font-size:0.9rem;">Suivi automatique des expirations</div>
                        <p class="text-muted mb-0" style="font-size:0.82rem; line-height:1.6;">
                            Le système analyse les dates d'expiration et permet d'envoyer des alertes email directement aux ressortissants concernés.
                        </p>
                    </div>
                </div>

                <div class="p-3 rounded-3 mb-3" style="background:#f8f9fa; border-left:4px solid var(--dgm-blue);">
                    <div class="fw-semibold mb-2" style="font-size:0.82rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--dgm-blue);">
                        <i class="fas fa-circle-dot me-1"></i>Statut des modules
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Email Gmail : Actif</span>
                        <span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>SMS : En attente</span>
                    </div>
                </div>

                @if($expiresBientot > 0)
                <div class="p-3 rounded-3" style="background:rgba(255,193,7,0.1); border-left:4px solid #ffc107;">
                    <div class="fw-semibold" style="font-size:0.85rem; color:#856404;">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        {{ $expiresBientot }} séjour(s) expire(nt) dans les 7 prochains jours.
                    </div>
                    <a href="{{ route('visas.index') }}" class="btn btn-sm btn-warning mt-2" style="font-size:0.8rem;">
                        Voir les séjours concernés
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
