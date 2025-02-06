<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../config/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$files = glob(__DIR__ . '/migrations/*.php');

foreach ($files as $file) {
    require_once $file;
}

echo "✅ Migrations rodadas com sucesso!\n";