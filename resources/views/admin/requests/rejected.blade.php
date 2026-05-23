@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-user-times me-2" style="color:var(--dgm-gold);"></i>Demandes rejetées</h1>
        <p>Historique des demandes refusées</p>
    </div>
    <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour aux demandes
    </a>
</div>

<div class="card">
    <div class="card-header dgm-header">
        <i class="fas fa-list me-2"></i>Demandes rejetées ({{ $requests->count() }})
    </div>
    <div class="card-body p-0">
        @if($requests->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox text-muted fa-3x mb-3"></i>
                <p class="text-muted">Aucune demande rejetée.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date rejet</th>
                            <th>Motif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td class="fw-semibold">{{ $request->name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->role === 'admin' ? 'Administrateur' : 'Agent DGM' }}</td>
                            <td>{{ $request->updated_at->format('d/m/Y') }}</td>
                            <td class="text-muted">{{ $request->motif_rejet ?? 'Aucun motif fourni' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection