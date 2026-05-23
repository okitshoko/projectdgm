@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-lock me-2" style="color:var(--dgm-gold);"></i>Modifier mon mot de passe</h1>
        <p>Changer votre mot de passe pour accéder au système</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header dgm-header">
                <i class="fas fa-lock me-2"></i>Changer le mot de passe
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-lock me-1 text-muted"></i>Mot de passe actuel
                        </label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-lock me-1 text-muted"></i>Nouveau mot de passe
                        </label>
                        <input type="password" name="password" class="form-control" required>
                        <div class="form-text" style="font-size:0.78rem;">
                            <i class="fas fa-info-circle me-1"></i>Minimum 6 caractères
                        </div>
                        @error('password')
                            <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-lock me-1 text-muted"></i>Confirmer le nouveau mot de passe
                        </label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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