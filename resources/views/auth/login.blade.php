<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGM — Connexion Agent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dgm-blue: #003087;
            --dgm-gold: #C8A951;
            --dgm-dark: #0a0f1e;
        }
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, var(--dgm-dark) 0%, #0d1b4b 50%, var(--dgm-blue) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .login-header {
            background: linear-gradient(135deg, var(--dgm-blue), #1a4a9e);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
        }
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 30px;
            background: #fff;
            border-radius: 50% 50% 0 0 / 30px 30px 0 0;
        }
        .login-logo {
            width: 72px; height: 72px;
            background: var(--dgm-gold);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 4px 20px rgba(200,169,81,0.4);
        }
        .login-header h2 {
            color: #fff;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
        }
        .login-header p {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            margin: 0.3rem 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .login-body { padding: 2rem; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #333; }
        .form-control {
            border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--dgm-blue);
            box-shadow: 0 0 0 3px rgba(0,48,135,0.1);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1.5px solid #e0e0e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
            color: #888;
        }
        .input-group .form-control { border-left: none; border-radius: 0 8px 8px 0; }
        .btn-login {
            background: linear-gradient(135deg, var(--dgm-blue), #1a4a9e);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #001f5c, var(--dgm-blue));
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,48,135,0.35);
        }
        .login-footer {
            background: #f8f9fa;
            padding: 1rem 2rem;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .login-footer p {
            font-size: 0.75rem;
            color: #999;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        /* Footer page */
        .page-footer {
            background: rgba(0,0,0,0.3);
            padding: 1rem 0;
            text-align: center;
        }
        .page-footer p {
            color: rgba(255,255,255,0.4);
            font-size: 0.75rem;
            margin: 0;
        }
        .page-footer strong { color: var(--dgm-gold); }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div>
            {{-- Emblème RDC --}}
            <div class="text-center mb-4">
                <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(200,169,81,0.15); border:1px solid rgba(200,169,81,0.3); border-radius:30px; padding:6px 16px;">
                    <i class="fas fa-flag" style="color:var(--dgm-gold); font-size:0.8rem;"></i>
                    <span style="color:rgba(255,255,255,0.8); font-size:0.75rem; letter-spacing:1px; text-transform:uppercase;">République Démocratique du Congo</span>
                </div>
            </div>

            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">
                        <i class="fas fa-passport fa-2x text-dark"></i>
                    </div>
                    <h2>DGM — LUBUMBASHI</h2>
                    <p>Accès réservé aux agents habilités</p>
                </div>

                <div class="login-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-3" style="font-size:0.85rem; border-left:4px solid #dc3545 !important;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control"
                                       placeholder="agent@dgm.cd"
                                       value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control"
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>SE CONNECTER
                        </button>
                    </form>
                </div>

                <div class="login-footer">
                    <p><i class="fas fa-shield-alt me-1"></i>Direction Générale de Migration — Lubumbashi, RDC</p>
                </div>
            </div>

            <div class="text-center mt-3">
                <p style="color:rgba(255,255,255,0.3); font-size:0.72rem; letter-spacing:0.5px;">
                    &copy; {{ date('Y') }} DGM — Développé par <span style="color:var(--dgm-gold);">OKIT</span>
                </p>
            </div>
        </div>
    </div>

    <footer class="page-footer">
        <p>✦ Développé avec passion par <strong>OKIT</strong> — Mémoire de fin d'études ✦</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
