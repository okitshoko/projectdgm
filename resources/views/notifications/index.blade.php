@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-bell me-2" style="color:var(--dgm-gold);"></i>Historique des alertes</h1>
        <p>Toutes les notifications envoyées aux ressortissants étrangers</p>
    </div>
    <span class="badge" style="background:var(--dgm-gold); color:#000; font-size:0.9rem; padding:8px 16px; border-radius:20px;">
        {{ count($notifications) }} alerte(s)
    </span>
</div>

<div class="card">
    <div class="card-header dgm-header">
        <i class="fas fa-history me-2"></i>Détail des alertes envoyées
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date d'envoi</th>
                        <th>Destinataire</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr>
                            <td class="text-muted" style="font-size:0.82rem;">{{ $loop->iteration }}</td>
                            <td style="font-size:0.85rem;">
                                <i class="fas fa-calendar me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($notification->date_envoi)->format('d/m/Y') }}
                                <div class="text-muted" style="font-size:0.75rem;">
                                    {{ \Carbon\Carbon::parse($notification->date_envoi)->format('H:i') }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold" style="font-size:0.88rem;">
                                    {{ $notification->visa->nom_etranger ?? 'N/A' }}
                                </div>
                                <div class="text-muted" style="font-size:0.75rem; font-family:monospace;">
                                    {{ $notification->visa->numero_passeport ?? '' }}
                                </div>
                            </td>
                            <td>
                                @if($notification->type_alerte == 'Email')
                                    <span class="badge" style="background:rgba(13,110,253,0.1); color:#0d6efd; border:1px solid rgba(13,110,253,0.2);">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-sms me-1"></i>SMS
                                    </span>
                                @endif
                            </td>
                            <td style="font-size:0.82rem; max-width:250px;">
                                <span class="text-muted">{{ Str::limit($notification->message, 60) }}</span>
                            </td>
                            <td>
                                @if($notification->statut_envoi === 'Succès')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Succès
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Échec
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-2">Aucune alerte n'a encore été envoyée.</p>
                                <a href="{{ route('visas.index') }}" class="btn btn-dgm btn-sm">
                                    <i class="fas fa-passport me-1"></i>Voir les séjours
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
