<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Obtenir le chemin vers lequel l'utilisateur doit être redirigé lorsqu'il n'est pas authentifié.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        // Si la requête attend du JSON (API), on ne redirige pas
        if ($request->expectsJson()) {
            return null;
        }

        // On redirige vers la route nommée 'login'
        // Dans ton web.php, 'login' correspond à la racine '/'
        return route('login');
    }
}