<?php
// header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/config/constants.php';

// Debug: Log BASE_URL
error_log("DEBUG: BASE_URL = " . BASE_URL);

// Don't delete this
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/php_errors.log');
ini_set('display_errors', '1');

// Log the request
logRequest();

# Classes to use
require_once __DIR__ . '/api/home.php';

# Define routes (no need to include BASE_URL here)
$routes = [
    'GET' => [
        '/' => ['home', 'welcome'], // Root route
    ],
    'POST' => [],
    'DELETE' => [],
];

// Debug: Log the raw request URI
error_log("DEBUG: Raw Request URI = " . $_SERVER['REQUEST_URI']);

// Parse the request URI and method
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parseEndpoint($_SERVER['REQUEST_URI']); // Parse and normalize URI

// Debug: Log the parsed request URI
error_log("DEBUG: Parsed Request URI = " . $requestUri);

$requestBody = json_decode(file_get_contents('php://input'), true);

$routeParams = [];
$response = handleRequest($routes, $requestMethod, $requestUri, $requestBody, $routeParams);

// Send the response
echo json_encode($response);

function handleRequest($routes, $method, $uri, $body, &$routeParams) {
    // Debug: Log available routes and current method
    error_log("DEBUG: Available Routes = " . print_r($routes[$method], true));
    error_log("DEBUG: Current Method = $method");
    error_log("DEBUG: Current URI = $uri");

    foreach ($routes[$method] ?? [] as $route => $handler) {
        // Debug: Log the route being checked
        error_log("DEBUG: Checking Route = $route");

        if (matchRoute($route, $uri, $routeParams)) {
            [$class, $function] = $handler;

            // Debug: Log the handler being called
            error_log("DEBUG: Handler Found: $class::$function");

            if (class_exists($class) && method_exists($class, $function)) {
                return call_user_func([new $class, $function], $routeParams, $body);
            }
        }
    }

    http_response_code(404);

    // Debug: Log 404 error
    error_log("DEBUG: 404 - Endpoint not found");
    return ["error" => "Endpoint not found"];
}

function matchRoute($route, $uri, &$params) {
    $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route);
    $pattern = '#^' . $pattern . '$#';

    // Debug: Log the matching process
    error_log("DEBUG: Matching URI '$uri' with Route Pattern '$pattern'");

    if (preg_match($pattern, $uri, $matches)) {
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }

        // Debug: Log successful match
        error_log("DEBUG: Route matched. Params: " . print_r($params, true));
        return true;
    }

    // Debug: Log unsuccessful match
    error_log("DEBUG: Route did not match.");
    return false;
}

function parseEndpoint($uri) {
    // Normalize and remove BASE_URL from the URI
    $baseUrl = rtrim(BASE_URL, '/'); // Remove trailing slash from BASE_URL
    if (strpos($uri, $baseUrl) === 0) {
        $uri = substr($uri, strlen($baseUrl)); // Strip BASE_URL from the beginning
    }

    // Debug: Log stripped URI
    error_log("DEBUG: Stripped URI = $uri");

    return '/' . ltrim(strtok(rtrim($uri, '/'), '?'), '/'); // Normalize URI to start with '/'
}

function logRequest() {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user-agent' => $_SERVER['HTTP_USER_AGENT'],
    ];

    // Debug: Log request details
    error_log("DEBUG: Request Details: " . print_r($logData, true));

    // file_put_contents(__DIR__ . '/logs/request.log', json_encode($logData) . PHP_EOL, FILE_APPEND);
}