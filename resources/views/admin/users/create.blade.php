@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-user-plus me-2" style="color:var(--dgm-gold);"></i>Créer un compte</h1>
        <p>Enregistrement d'un nouvel agent ou administrateur DGM</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header dgm-header">
                <i class="fas fa-id-badge me-2"></i>Informations du nouveau compte
            </div>
            <div class="card-body p-4">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-user me-1 text-muted"></i>Nom complet
                        </label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}"
                               placeholder="Ex: Jean Kabila" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-envelope me-1 text-muted"></i>Adresse email
                        </label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}"
                               placeholder="agent@dgm.cd" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-shield-alt me-1 text-muted"></i>Rôle dans le système
                        </label>
                        <select name="role" class="form-select" required>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent DGM</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                        <div class="form-text" style="font-size:0.78rem;">
                            <i class="fas fa-info-circle me-1"></i>
                            L'administrateur a accès à la gestion des comptes. L'agent a accès aux séjours uniquement.
                        </div>
                    </div>

                    <hr style="border-color:#eef0f5;">

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-lock me-1 text-muted"></i>Mot de passe
                        </label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Minimum 6 caractères" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-lock me-1 text-muted"></i>Confirmer le mot de passe
                        </label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Répéter le mot de passe" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dgm px-4">
                            <i class="fas fa-save me-1"></i>Créer le compte
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
