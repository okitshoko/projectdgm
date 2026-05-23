<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationRequestController;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login-check', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegistrationRequestController::class, 'create'])->name('register');
Route::post('/register', [RegistrationRequestController::class, 'store'])->name('register.store');


// --- PARTIE PRIVÉE (Agents Connectés uniquement) ---
Route::middleware(['auth'])->group(function () {

    // Tableau de bord principal
    Route::get('/dashboard', [VisaController::class, 'dashboard'])->name('dashboard');

    // Gestion des Séjours (Visas)
    Route::prefix('visas')->name('visas.')->group(function () {
        Route::get('/', [VisaController::class, 'index'])->name('index');
        Route::get('/create', [VisaController::class, 'create'])->name('create');
        Route::post('/store', [VisaController::class, 'store'])->name('store');
        Route::get('/{visa}', [VisaController::class, 'show'])->name('show');
        
        // Alertes et Emails
        Route::get('/{visa}/avertissement', [VisaController::class, 'avertissement'])->name('avertissement');
        Route::post('/{visa}/envoyer-alerte', [VisaController::class, 'envoyerAlerte'])->name('envoyerAlerte');
    });

    // Gestion des Pays (Nationalités)
    Route::resource('countries', CountryController::class);

    // Historique des Notifications (Gmail / SMS)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Mot de passe (accessible par tout utilisateur connecté pour son propre compte)
    Route::get('/password/edit', [UserController::class, 'editPassword'])->name('password.edit');
    Route::put('/password/update', [UserController::class, 'updatePassword'])->name('password.update');

    // Profil (accessible par tout utilisateur connecté pour son propre compte)
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // --- PARTIE ADMIN (Super Administrateur uniquement) ---
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        
        Route::get('/requests', [RegistrationRequestController::class, 'index'])->name('requests.index');
        Route::post('/requests/{registrationRequest}/approve', [RegistrationRequestController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{registrationRequest}/reject', [RegistrationRequestController::class, 'reject'])->name('requests.reject');
        Route::get('/requests/rejected', [RegistrationRequestController::class, 'rejected'])->name('requests.rejected');
    });
});