@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1><i class="fas fa-globe-africa me-2" style="color:var(--dgm-gold);"></i>Gestion des pays</h1>
    <p>Référentiel des nationalités et pays de provenance des ressortissants étrangers</p>
</div>

<div class="row g-4">
    {{-- Formulaire d'ajout --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header dgm-header">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un pays
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success mb-3" style="font-size:0.85rem;">
                        <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3" style="font-size:0.85rem;">
                        @foreach($errors->all() as $error)
                            <div><i class="fas fa-times-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('countries.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-flag me-1 text-muted"></i>Nom du pays
                        </label>
                        <input type="text" class="form-control" name="nom_pays"
                               value="{{ old('nom_pays') }}"
                               placeholder="Ex: France" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">
                            <i class="fas fa-barcode me-1 text-muted"></i>Code ISO / Indicatif
                        </label>
                        <input type="text" class="form-control" name="code_iso"
                               value="{{ old('code_iso') }}"
                               placeholder="Ex: FR ou +33" required>
                    </div>
                    <button type="submit" class="btn btn-dgm w-100">
                        <i class="fas fa-save me-1"></i>Enregistrer le pays
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Liste des pays --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header dgm-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>Pays enregistrés</span>
                <span class="badge bg-light text-dark">{{ $countries->count() }} pays</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du pays</th>
                                <th>Code ISO</th>
                                <th>Séjours enregistrés</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($countries as $country)
                                <tr>
                                    <td class="text-muted" style="font-size:0.82rem;">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:30px; height:30px; background:rgba(0,48,135,0.1); border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                <i class="fas fa-flag text-primary" style="font-size:0.7rem;"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $country->nom_pays }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background:rgba(0,48,135,0.1); color:var(--dgm-blue); font-weight:600;">
                                            {{ $country->code_iso }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $country->visas->count() }} séjour(s)
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="fas fa-globe fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Aucun pays enregistré. Ajoutez le premier pays.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
