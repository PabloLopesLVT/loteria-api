<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/routes.php';

date_default_timezone_set('America/Sao_Paulo');

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Verifica se a rota está definida no routes.php
if (isset($routes[$method][$request_uri])) {
    $callback = $routes[$method][$request_uri];
    echo json_encode($callback());
} else {
    http_response_code(404);
    echo json_encode(["error" => "Rota não encontrada"]);
}
