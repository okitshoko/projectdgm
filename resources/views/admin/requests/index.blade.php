@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-user-clock me-2" style="color:var(--dgm-gold);"></i>Demandes de compte</h1>
        <p>Demandes en attente d'approbation</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header dgm-header">
        <i class="fas fa-list me-2"></i>Demandes en attente ({{ $requests->count() }})
    </div>
    <div class="card-body p-0">
        @if($requests->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <p class="text-muted">Aucune demande en attente.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle demandé</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($request->photo)
                                    <img src="{{ Storage::url($request->photo) }}" class="rounded-circle" style="width:36px; height:36px; object-fit:cover;">
                                @else
                                    <div style="width:36px; height:36px; background:rgba(0,48,135,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $request->name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>
                                <span class="badge" style="background:var(--dgm-blue); color:#fff;">
                                    {{ $request->role === 'admin' ? 'Administrateur' : 'Agent DGM' }}
                                </span>
                            </td>
                            <td>{{ $request->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.requests.approve', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Approuver">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                                
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter la demande</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.requests.reject', $request->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir rejeter la demande de <strong>{{ $request->name }}</strong>?</p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Motif du rejet (optionnel)</label>
                                                        <textarea name="motif_rejet" class="form-control" rows="3" placeholder="Raison du rejet..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger">Rejeter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection