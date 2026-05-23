<?php

// 1. Charger l'autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Initialiser l'application Laravel (Bootstrap)
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Gérer la requête entrante via le Kernel de Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);