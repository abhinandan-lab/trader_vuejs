<?php
require_once '../config.php';
require_once '../functions/database.php';
require_once '../functions/helpers.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'register':
        if ($requestMethod === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = registerUser($data);
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Invalid request method"]);
        }
        break;
    default:
        echo json_encode(["error" => "Invalid API endpoint"]);
        break;
}
?>
