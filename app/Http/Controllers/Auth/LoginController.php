<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        // Si l'agent est déjà connecté, on l'envoie direct à l'accueil
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion
     */
    public function login(Request $request)
    {
        // 1. Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tentative de connexion
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Bienvenue, ' . Auth::user()->name . ' ! Vous êtes connecté.');
        }

        // 3. Si ça échoue
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion de l'agent
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}