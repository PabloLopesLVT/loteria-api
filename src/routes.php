<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/controllers/BilheteController.php';

use App\Controllers\BilheteController;

$routes = [
    'POST' => [
        '/bilhetes' => function () {
            $controller = new BilheteController();
            return $controller->gerarBilhetes();
        }
    ],
    'GET' => [
        '/bilhetes' => function () {
            $controller = new BilheteController();
            return $controller->listarBilhetes();
        },
        '/bilhete/premiado' => function () {
            $controller = new BilheteController();
            return $controller->gerarBilhetePremiado();
        }
    ]
];
