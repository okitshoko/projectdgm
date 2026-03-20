@extends('layouts.app')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1><i class="fas fa-exclamation-triangle me-2" style="color:var(--dgm-gold);"></i>Envoi d'alerte d'expiration</h1>
        <p>Préparation de la notification pour <strong>{{ $visa->nom_etranger }}</strong></p>
    </div>
    <a href="{{ route('visas.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Aperçu du message --}}
        <div class="card mb-4">
            <div class="card-header" style="background:linear-gradient(135deg, #8B6914, var(--dgm-gold)); color:#fff;">
                <i class="fas fa-envelope-open-text me-2"></i>Aperçu du message qui sera envoyé
            </div>
            <div class="card-body p-4">
                <div class="p-3 rounded-3 mb-3" style="background:#f8f9fa; border:1px solid #e0e0e0;">
                    <div class="mb-2">
                        <span class="text-muted" style="font-size:0.8rem; font-weight:600;">DESTINATAIRE :</span>
                        <span class="ms-2 fw-semibold">{{ $visa->email_contact }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted" style="font-size:0.8rem; font-weight:600;">OBJET :</span>
                        <span class="ms-2">⚠️ Rappel d'expiration de séjour — DGM</span>
                    </div>
                    <hr style="border-color:#ddd;">
                    <p style="font-size:0.9rem; line-height:1.7; margin:0;">
                        Monsieur/Madame <strong>{{ $visa->nom_etranger }}</strong>,<br><br>
                        Nous vous informons que votre visa (Passeport : <strong>{{ $visa->numero_passeport }}</strong>)
                        expire le <strong>{{ \Carbon\Carbon::parse($visa->date_expiration)->format('d/m/Y') }}</strong>.<br><br>
                        Veuillez vous présenter à la Direction Générale de Migration pour régulariser votre situation avant cette date.
                    </p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:rgba(0,48,135,0.05); border:1px solid rgba(0,48,135,0.1);">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase;">Ressortissant</div>
                            <div class="fw-bold">{{ $visa->nom_etranger }}</div>
                            <div class="text-muted" style="font-size:0.82rem;">{{ $visa->numero_passeport }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:rgba(220,53,69,0.05); border:1px solid rgba(220,53,69,0.1);">
                            <div class="text-muted mb-1" style="font-size:0.75rem; font-weight:600; text-transform:uppercase;">Date d'expiration</div>
                            <div class="fw-bold text-danger">{{ \Carbon\Carbon::parse($visa->date_expiration)->format('d/m/Y') }}</div>
                            <div class="text-muted" style="font-size:0.82rem;">
                                @if(\Carbon\Carbon::parse($visa->date_expiration)->isPast())
                                    Expiré depuis {{ now()->diffInDays(\Carbon\Carbon::parse($visa->date_expiration)) }} jours
                                @else
                                    Dans {{ \Carbon\Carbon::parse($visa->date_expiration)->diffInDays(now()) }} jours
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <i class="fas fa-paper-plane fa-2x" style="color:var(--dgm-gold);"></i>
                    <div>
                        <div class="fw-bold">Confirmer l'envoi de l'alerte</div>
                        <div class="text-muted" style="font-size:0.82rem;">
                            L'email sera envoyé à <strong>{{ $visa->email_contact }}</strong> et l'action sera enregistrée dans l'historique.
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('visas.envoyerAlerte', $visa->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dgm-gold px-4">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer l'alerte maintenant
                        </button>
                    </form>
                    <a href="{{ route('visas.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-1"></i>Annuler
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
