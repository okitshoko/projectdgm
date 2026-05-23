<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGM — Système de Suivi des Séjours</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dgm-blue: #003087;
            --dgm-gold: #C8A951;
            --dgm-dark: #0a0f1e;
            --dgm-light: #f0f4f8;
            --bg-body: #f0f4f8;
            --text-body: #1a1a2e;
            --card-bg: #ffffff;
            --card-border: rgba(0,0,0,0.06);
            --table-border: #eef0f5;
            --table-hover: rgba(0,48,135,0.04);
        }

        [data-theme="dark"] {
            --bg-body: #0f1419;
            --text-body: #e4e6eb;
            --card-bg: #1c2128;
            --card-border: rgba(255,255,255,0.06);
            --table-border: #2d333b;
            --table-hover: rgba(255,255,255,0.04);
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-body);
            color: var(--text-body);
            transition: background-color 0.3s, color 0.3s;
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .theme-toggle:hover {
            background: rgba(255,255,255,0.2);
        }
        .theme-toggle i {
            transition: transform 0.3s;
        }
        .theme-toggle .fa-sun { display: none; }
        [data-theme="dark"] .theme-toggle .fa-sun { display: inline; }
        [data-theme="dark"] .theme-toggle .fa-moon { display: none; }
        [data-theme="dark"] .theme-toggle i { transform: rotate(180deg); }

        /* ===== NAVBAR ===== */
        .navbar-dgm {
            background: linear-gradient(135deg, var(--dgm-dark) 0%, var(--dgm-blue) 100%);
            border-bottom: 3px solid var(--dgm-gold);
            padding: 0.6rem 0;
        }
        .navbar-dgm .navbar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            color: #fff !important;
        }
        .navbar-dgm .navbar-brand .brand-sub {
            font-size: 0.72rem;
            font-weight: 300;
            color: rgba(255,255,255,0.7);
            display: block;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .navbar-dgm .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.5rem 0.9rem !important;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .navbar-dgm .nav-link:hover,
        .navbar-dgm .nav-link.active {
            background: rgba(200,169,81,0.2);
            color: var(--dgm-gold) !important;
        }
        .navbar-dgm .nav-link.active {
            border-bottom: 2px solid var(--dgm-gold);
        }
        .badge-role {
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 20px;
            background: var(--dgm-gold);
            color: #000;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background-color: var(--card-bg);
            transition: background-color 0.3s;
        }
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            border-bottom: 1px solid var(--card-border);
            font-weight: 600;
            background-color: var(--card-bg);
            transition: background-color 0.3s, border-color 0.3s;
        }
        .card-header.dgm-header {
            background: linear-gradient(135deg, var(--dgm-blue), #1a4a9e);
            color: #fff;
        }
        .card-header.dgm-header-gold {
            background: linear-gradient(135deg, #8B6914, var(--dgm-gold));
            color: #fff;
        }

        /* ===== TABLES ===== */
        .table {
            --bs-table-bg: var(--card-bg);
            --bs-table-color: var(--text-body);
            --bs-table-border-color: var(--table-border);
        }
        .table thead th {
            background: var(--dgm-blue);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 0.85rem 1rem;
        }
        .table tbody tr:hover {
            background-color: var(--table-hover);
        }
        .table tbody td {
            vertical-align: middle;
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
            border-color: var(--table-border);
            color: var(--text-body);
        }

        /* ===== BUTTONS ===== */
        .btn-dgm {
            background: linear-gradient(135deg, var(--dgm-blue), #1a4a9e);
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            transition: all 0.2s;
        }
        .btn-dgm:hover {
            background: linear-gradient(135deg, #001f5c, var(--dgm-blue));
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,48,135,0.3);
        }
        .btn-dgm-gold {
            background: linear-gradient(135deg, #8B6914, var(--dgm-gold));
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-dgm-gold:hover {
            background: linear-gradient(135deg, #6b5010, #8B6914);
            color: #fff;
        }

        /* ===== ALERTS ===== */
        .alert-success { border-left: 4px solid #00ec00; }
        .alert-danger  { border-left: 4px solid #ff0000; }
        .alert-warning { border-left: 4px solid #ffbf00; }

        /* ===== FOOTER ===== */
        .footer-dgm {
            background: linear-gradient(135deg, var(--dgm-dark) 0%, var(--dgm-blue) 100%);
            border-top: 3px solid var(--dgm-gold);
            color: rgba(255,255,255,0.8);
            padding: 2rem 0 1rem;
        }
        .footer-dgm h6 {
            color: var(--dgm-gold);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
        }
        .footer-dgm .footer-divider {
            border-color: rgba(200,169,81,0.3);
        }
        .footer-dgm .dedicace {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
        }
        .footer-dgm .dedicace strong {
            color: var(--dgm-gold);
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, var(--dgm-blue), #1a4a9e);
            color: #fff;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
        }
        .page-header h1 { font-size: 1.4rem; font-weight: 700; margin: 0; }
        .page-header p  { font-size: 0.85rem; opacity: 0.8; margin: 0.3rem 0 0; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-radius: 12px;
            padding: 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.3;
            position: absolute;
            right: 1.5rem;
            bottom: 1rem;
        }
        .stat-card .stat-value { font-size: 2.2rem; font-weight: 700; }
        .stat-card .stat-label { font-size: 0.8rem; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- ===== BARRE SUPÉRIEURE ===== --}}
    <div style="background: var(--dgm-gold); padding: 4px 0;">
        <div class="container d-flex justify-content-between align-items-center">
            <span style="font-size:0.72rem; color:#000; font-weight:600; letter-spacing:1px; text-transform:uppercase;">
                <i class="fas fa-flag me-1"></i> République Démocratique du Congo
            </span>
            @auth
            <span style="font-size:0.72rem; color:#000;">
                <i class="fas fa-circle text-success me-1" style="font-size:0.5rem;"></i>
                Connecté : <strong>{{ Auth::user()->name }}</strong>
                @if(Auth::user()->isAdmin()) <span class="badge-role ms-1">Admin</span> @endif
            </span>
            @endauth
        </div>
    </div>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-lg navbar-dgm sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <div style="background: var(--dgm-gold); border-radius: 8px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-passport text-dark"></i>
                </div>
                <div>
                    <span>DGM — LUBUMBASHI - RDC</span>
                    <span class="brand-sub">Système de Suivi des Séjours</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-1">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home me-1"></i> Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('visas.*') ? 'active' : '' }}" href="{{ route('visas.index') }}">
                                <i class="fas fa-passport me-1"></i> Séjours
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('countries.*') ? 'active' : '' }}" href="{{ route('countries.index') }}">
                                <i class="fas fa-globe-africa me-1"></i> Pays
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell me-1"></i> Alertes
                            </a>
                        </li>
                        @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users-cog me-1"></i> Administration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}" href="{{ route('admin.requests.index') }}">
                                <i class="fas fa-user-clock me-1"></i> Demandes
                            </a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <button class="theme-toggle" onclick="toggleTheme()" title="Changer le thème">
                                <i class="fas fa-moon"></i>
                                <i class="fas fa-sun"></i>
                            </button>
                        </li>

                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                                @if(Auth::user()->photo)
                                    <img src="{{ Storage::url(Auth::user()->photo) }}" class="rounded-circle" style="width:30px; height:30px; object-fit:cover;">
                                @else
                                    <div style="background: var(--dgm-gold); border-radius: 50%; width:30px; height:30px; display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-user text-dark" style="font-size:0.75rem;"></i>
                                    </div>
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:10px; min-width:200px;">
                                <li class="px-3 py-2">
                                    <div class="fw-bold" style="font-size:0.9rem;">{{ Auth::user()->name }}</div>
                                    <div class="text-muted" style="font-size:0.78rem;">{{ Auth::user()->email }}</div>
                                    <span class="badge mt-1" style="background:var(--dgm-blue); font-size:0.7rem;">
                                        {{ Auth::user()->role === 'admin' ? 'Administrateur' : 'Agent DGM' }}
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2"></i>Mon profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('password.edit') }}">
                                        <i class="fas fa-lock me-2"></i>Changer le mot de passe
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <button class="theme-toggle" onclick="toggleTheme()" title="Changer le thème">
                                <i class="fas fa-moon"></i>
                                <i class="fas fa-sun"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-lock me-1"></i> Connexion Agent
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- ===== CONTENU PRINCIPAL ===== --}}
    <main class="flex-grow-1 py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any() && !session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs dans le formulaire.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer-dgm mt-auto">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-4">
                    <h6><i class="fas fa-passport me-2"></i>DGM — LUBUMBASHI -- RDC</h6>
                    <p style="font-size:0.82rem; color:rgba(255,255,255,0.6); line-height:1.6;">
                        Outil officiel de la Direction Générale de Migration pour le contrôle et la gestion des séjours des ressortissants étrangers en RDC.
                    </p>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-map-marker-alt me-2"></i>Coordonnées</h6>
                    <address style="font-size:0.82rem; color:rgba(255,255,255,0.6); font-style:normal; line-height:1.8;">
                        Direction Générale de Migration<br>
                        LUBUMBASHI, République Démocratique du Congo<br>
                        <i class="fas fa-envelope me-1"></i> dgmlubumbashi12@gmail.com
                    </address>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-shield-alt me-2"></i>Accès Sécurisé</h6>
                    <p style="font-size:0.82rem; color:rgba(255,255,255,0.6); line-height:1.6;">
                        Système réservé aux agents habilités de la DGM. Toute tentative d'accès non autorisé est passible de poursuites.
                    </p>
                </div>
            </div>
            <hr class="footer-divider my-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="dedicace">
                    &copy; {{ date('Y') }} Direction Générale de Migration — République Démocratique du Congo
                </div>
                <div class="dedicace text-center">
                    ✦ Développé avec passion par <strong>OKIT</strong> — Mémoire de fin d'études ✦
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</body>
</html>
