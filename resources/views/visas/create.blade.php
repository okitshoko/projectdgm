@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-plus-circle me-2" style="color:var(--dgm-gold);"></i>Nouvel enregistrement</h1>
        <p>Enregistrement d'un ressortissant étranger dans le système DGM</p>
    </div>
    <a href="{{ route('visas.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header dgm-header">
                <i class="fas fa-passport me-2"></i>Formulaire d'enregistrement d'un séjour
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

                <form action="{{ route('visas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Photo --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:28px; height:28px; background:var(--dgm-blue); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <span style="color:#fff; font-size:0.75rem; font-weight:700;">1</span>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:var(--dgm-blue); text-transform:uppercase; letter-spacing:0.5px; font-size:0.82rem;">
                                Photo du passeport (optionnel)
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-camera me-1 text-muted"></i>Photo du passeport
                                </label>
                                <input type="file" class="form-control" name="photo" accept="image/*">
                                <div class="form-text" style="font-size:0.78rem;">
                                    <i class="fas fa-info-circle me-1"></i>Formats acceptés: JPEG, PNG, JPG, GIF (max 2Mo)
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#eef0f5;">

                    {{-- Section 2 : Identité --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:28px; height:28px; background:var(--dgm-blue); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <span style="color:#fff; font-size:0.75rem; font-weight:700;">2</span>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:var(--dgm-blue); text-transform:uppercase; letter-spacing:0.5px; font-size:0.82rem;">
                                Identité du ressortissant
                            </h6>
                        </div>
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:28px; height:28px; background:var(--dgm-blue); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <span style="color:#fff; font-size:0.75rem; font-weight:700;">1</span>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:var(--dgm-blue); text-transform:uppercase; letter-spacing:0.5px; font-size:0.82rem;">
                                Identité du ressortissant
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-user me-1 text-muted"></i>Nom complet
                                </label>
                                <input type="text" class="form-control" name="nom_etranger"
                                       value="{{ old('nom_etranger') }}"
                                       placeholder="Ex: Jean Dupont" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-id-card me-1 text-muted"></i>Numéro de passeport
                                </label>
                                <input type="text" class="form-control" name="numero_passeport"
                                       value="{{ old('numero_passeport') }}"
                                       placeholder="Ex: AB123456" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-globe-africa me-1 text-muted"></i>Nationalité (pays)
                                </label>
                                <select class="form-select" name="country_id" required>
                                    <option value="" disabled selected>Sélectionner un pays...</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->nom_pays }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-tag me-1 text-muted"></i>Type de visa
                                </label>
                                <select class="form-select" name="type_visa" required>
                                    <option value="Touristique" {{ old('type_visa') == 'Touristique' ? 'selected' : '' }}>Touristique</option>
                                    <option value="Travail" {{ old('type_visa') == 'Travail' ? 'selected' : '' }}>Travail</option>
                                    <option value="Études" {{ old('type_visa') == 'Études' ? 'selected' : '' }}>Études</option>
                                    <option value="Établissement" {{ old('type_visa') == 'Établissement' ? 'selected' : '' }}>Établissement permanent</option>
                                    <option value="Diplomatique" {{ old('type_visa') == 'Diplomatique' ? 'selected' : '' }}>Diplomatique</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#eef0f5;">

                    {{-- Section 3 : Dates --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:28px; height:28px; background:var(--dgm-blue); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <span style="color:#fff; font-size:0.75rem; font-weight:700;">3</span>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:var(--dgm-blue); text-transform:uppercase; letter-spacing:0.5px; font-size:0.82rem;">
                                Période de séjour
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-calendar-check me-1 text-muted"></i>Date d'entrée en RDC
                                </label>
                                <input type="date" class="form-control" name="date_entree"
                                       value="{{ old('date_entree') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-calendar-times me-1 text-muted"></i>Date d'expiration du visa
                                </label>
                                <input type="date" class="form-control" name="date_expiration"
                                       value="{{ old('date_expiration') }}" required>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#eef0f5;">

                    {{-- Section 4 : Contacts --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width:28px; height:28px; background:var(--dgm-blue); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                                <span style="color:#fff; font-size:0.75rem; font-weight:700;">4</span>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color:var(--dgm-blue); text-transform:uppercase; letter-spacing:0.5px; font-size:0.82rem;">
                                Contacts pour les alertes
                            </h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-envelope me-1 text-muted"></i>Adresse email
                                </label>
                                <input type="email" class="form-control" name="email_contact"
                                       value="{{ old('email_contact') }}"
                                       placeholder="etranger@exemple.com" required>
                                <div class="form-text" style="font-size:0.78rem;">
                                    <i class="fas fa-info-circle me-1"></i>Recevra les alertes d'expiration par email.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.85rem;">
                                    <i class="fas fa-phone me-1 text-muted"></i>Numéro de téléphone
                                </label>
                                <input type="text" class="form-control" name="telephone_contact"
                                       value="{{ old('telephone_contact') }}"
                                       placeholder="+243XXXXXXXXX" required>
                                <div class="form-text" style="font-size:0.78rem;">
                                    <i class="fas fa-info-circle me-1"></i>Format international recommandé.
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#eef0f5;">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dgm px-4">
                            <i class="fas fa-save me-1"></i>Enregistrer le séjour
                        </button>
                        <a href="{{ route('visas.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
