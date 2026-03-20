@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-users-cog me-2" style="color:var(--dgm-gold);"></i>Administration des comptes</h1>
        <p>Gestion des agents et administrateurs du système DGM</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-dgm-gold">
        <i class="fas fa-user-plus me-1"></i> Créer un compte
    </a>
</div>

{{-- Statistiques --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #198754, #28a745);">
            <div class="stat-label">Agents connectés maintenant</div>
            <div class="stat-value">{{ count($activeUserIds) }}</div>
            <i class="fas fa-circle stat-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #003087, #1a4a9e);">
            <div class="stat-label">Total des comptes</div>
            <div class="stat-value">{{ $users->count() }}</div>
            <i class="fas fa-users stat-icon"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #8B0000, #dc3545);">
            <div class="stat-label">Administrateurs</div>
            <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
            <i class="fas fa-shield-alt stat-icon"></i>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header dgm-header">
        <i class="fas fa-list me-2"></i>Liste des comptes enregistrés
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Statut</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Créé le</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted" style="font-size:0.82rem;">{{ $loop->iteration }}</td>
                    <td>
                        @if(in_array($user->id, $activeUserIds))
                            <span class="badge bg-success" style="font-size:0.72rem;">
                                <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>En ligne
                            </span>
                        @else
                            <span class="badge bg-secondary" style="font-size:0.72rem;">
                                <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>Hors ligne
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px; height:32px; background:{{ $user->role === 'admin' ? 'rgba(220,53,69,0.1)' : 'rgba(0,48,135,0.1)' }}; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'shield-alt text-danger' : 'user text-primary' }}" style="font-size:0.75rem;"></i>
                            </div>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.88rem;">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Administrateur</span>
                        @else
                            <span class="badge" style="background:rgba(0,48,135,0.1); color:var(--dgm-blue);">Agent DGM</span>
                        @endif
                    </td>
                    <td style="font-size:0.82rem; color:#666;">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                              onsubmit="return confirm('Supprimer le compte de {{ $user->name }} ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px; padding:4px 10px;" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @else
                            <span class="badge bg-light text-muted border" style="font-size:0.72rem;">Votre compte</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">Aucun compte trouvé.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-light" style="font-size:0.78rem; color:#888;">
        <i class="fas fa-info-circle me-1"></i>
        Un agent est considéré "En ligne" s'il a été actif dans les 30 dernières minutes.
    </div>
</div>

@endsection
