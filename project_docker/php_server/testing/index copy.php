<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



# constants , required dont delte this
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/functions/Utils.php';


# dont delete this
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/php_errors.log');
ini_set('display_errors', '1');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
logRequest();








# classes to use
require_once __DIR__ . '/api/home.php';


// ddd(BASEFOLDER);


# define routes here
$routes = [
    'GET' => [
        // BASEFOLDER . '/' => ['home', 'welcome'],
        // '/testing' => ['home', 'welcome'],
        '/testing/t/' => ['home', 'welcome'],

    ],
    'POST' => [],
    'DELETE' => [],
];




$routes = prependBaseFolder($routes);






// dont change below anything


$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parseEndpoint($_SERVER['REQUEST_URI']) ?:  BASEFOLDER; // Default to '/' if no URI is provided
$requestBody = json_decode(file_get_contents('php://input'), true);

$routeParams = [];
$response = handleRequest($routes, $requestMethod, $requestUri, $requestBody, $routeParams);

// echo json_encode($response);

function handleRequest($routes, $method, $uri, $body, &$routeParams) {

    // ddd($uri);
    // ddd($body);
    // ddd($routeParams);


    
    
    
    
    foreach ($routes[$method] ?? [] as $route => $handler) {
        ddd(matchRoute($route, $uri, $routeParams));
        if (matchRoute($route, $uri, $routeParams)) {
            [$class, $function] = $handler;
            if (class_exists($class) && method_exists($class, $function)) {
                return call_user_func([new $class, $function], $routeParams, $body);
            }
        }
    }

    http_response_code(404);
    return ["error" => "Endpoint not found"];
}

function matchRoute($route, $uri, &$params) {
    $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route);
    $pattern = '#^' . $pattern . '$#';

    // ddd($pattern);
    // ddd($uri);
    // ddd($matches);

    if (preg_match($pattern, $uri, $matches)) {
        foreach ($matches as $key => $value) {

            ddd($matches);
            ddd($key);
            ddd($value);

            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }
        return true;
    }
    return false;
}

function parseEndpoint($uri) {
    return strtok(rtrim($uri, '/'), '?');
}

function logRequest() {
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user-agent' => $_SERVER['HTTP_USER_AGENT'],
    ];
    # dont delete this
    // file_put_contents(__DIR__ . '/logs/request.log', json_encode($logData) . PHP_EOL, FILE_APPEND);
}