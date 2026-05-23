<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGM — Demande de compte</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --dgm-blue: #003087;
            --dgm-gold: #C8A951;
            --bg-color: #ecf0f3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .republic-header {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 48, 135, 0.05);
            border: 1px solid rgba(0, 48, 135, 0.1);
            border-radius: 30px;
            padding: 6px 16px;
            margin-bottom: 25px;
        }

        .republic-header span {
            color: #555;
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            border-radius: 40px;
            background-color: var(--bg-color);
            box-shadow: 13px 13px 20px #cbced1, 
                       -13px -13px 20px #ffffff;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 15px;
            background-color: var(--dgm-blue);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo i {
            color: var(--dgm-gold);
            font-size: 25px;
        }

        h2 {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--dgm-blue);
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 0.7rem;
            color: #777;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .alert-error {
            background: #ffe5e5;
            color: #d9534f;
            padding: 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-bottom: 15px;
            text-align: left;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }

        .input-group {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            border-radius: 15px;
            box-shadow: inset 6px 6px 6px #cbced1, 
                        inset -6px -6px 6px #ffffff;
        }

        .input-group i {
            padding: 12px 5px 12px 15px;
            color: var(--dgm-blue);
        }

        .input-group input, .input-group select {
            border: none;
            outline: none;
            background: none;
            padding: 12px;
            width: 100%;
            color: #333;
            font-size: 0.85rem;
        }

        .file-input {
            text-align: left;
            padding: 10px 15px;
            font-size: 0.8rem;
            color: #666;
        }

        .login-btn {
            width: 100%;
            height: 50px;
            border-radius: 15px;
            border: none;
            background-color: var(--dgm-blue);
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        .card-footer {
            margin-top: 20px;
            font-size: 0.7rem;
        }

        .card-footer a {
            color: var(--dgm-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="republic-header">
        <i class="fas fa-flag" style="color:var(--dgm-gold);"></i>
        <span>République Démocratique du Congo</span>
    </div>

    <div class="login-card">
        <div class="logo">
            <i class="fas fa-user-plus"></i>
        </div>
        
        <h2>Demande de compte</h2>
        <p class="subtitle">Soumettre une demande d'accès</p>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <i class="fas fa-exclamation-circle"></i> {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Nom complet" value="{{ old('name') }}" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email professionnel" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <i class="fas fa-user-tag"></i>
                <select name="role" required>
                    <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent DGM</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Mot de passe (min 6 caractères)" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
            </div>

            <div class="input-group file-input">
                <i class="fas fa-camera" style="margin-right:10px;"></i>
                <input type="file" name="photo" accept="image/*">
            </div>

            <button type="submit" class="login-btn">
                SOUMETTRE LA DEMANDE
            </button>
        </form>

        <div class="card-footer">
            <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Retour à la connexion</a>
        </div>
    </div>

</body>
</html>