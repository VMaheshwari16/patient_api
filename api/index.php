<?php
require_once __DIR__ . "/middlewares/JsonMiddleware.php";
require_once __DIR__ . "/controllers/PatientController.php";

JsonMiddleware::handle();

$request = $_GET['request'] ?? '';
$parts   = explode('/', trim($request, '/'));

$resource = $parts[0] ?? '';
$id       = $parts[1] ?? null;
$method   = $_SERVER['REQUEST_METHOD'];

if ($resource === 'patients') {
    (new PatientController())->handle($method, $id);
} else {
    http_response_code(404);
    echo json_encode([
        "status" => false,
        "message" => "Endpoint not found"
    ]);
}
