<?php

use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/debug-requests', function () {
    $requests = RegistrationRequest::where('statut', 'en_attente')->get();
    
    foreach ($requests as $req) {
        echo "ID: " . $req->id . "<br>";
        echo "Name: '" . $req->name . "'<br>";
        echo "Email: '" . $req->email . "'<br>";
        echo "Role: '" . $req->role . "'<br>";
        echo "Photo: '" . $req->photo . "'<br>";
        echo "Password hash: '" . substr($req->password, 0, 20) . "...'<br>";
        echo "<hr>";
    }
    
    if ($requests->isEmpty()) {
        echo "Aucune demande en attente";
    }
});