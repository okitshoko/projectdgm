@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-user-edit me-2" style="color:var(--dgm-gold);"></i>Mon profil</h1>
        <p>Modifier vos informations personnelles</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header dgm-header">
                <i class="fas fa-user me-2"></i>Mes informations
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width:120px; height:120px;">
                                <i class="fas fa-user text-muted" style="font-size:3rem;"></i>
                            </div>
                        @endif
                        <div>
                            <label class="btn btn-outline-secondary btn-sm" style="cursor:pointer;">
                                <i class="fas fa-camera me-1"></i> Changer la photo
                                <input type="file" name="photo" accept="image/*" style="display:none;" onchange="this.form.submit()">
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-user me-1 text-muted"></i>Nom complet
                        </label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-envelope me-1 text-muted"></i>Adresse email
                        </label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                        <div class="form-text" style="font-size:0.78rem;">
                            <i class="fas fa-info-circle me-1"></i>L'email ne peut pas être modifié.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-shield-alt me-1 text-muted"></i>Rôle
                        </label>
                        <input type="text" class="form-control" value="{{ Auth::user()->role === 'admin' ? 'Administrateur' : 'Agent DGM' }}" disabled>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dgm px-4">
                            <i class="fas fa-save me-1"></i>Enregistrer
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection