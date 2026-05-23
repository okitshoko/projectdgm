<?php

// 1. Charger l'autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Démarrer l'application Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Exécuter le point d'entrée public
require __DIR__ . '/../public/index.php';