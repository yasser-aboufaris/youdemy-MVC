<?php
session_start();

include './vendor/autoload.php'; 


$router = new App\Rooter\SimpleRouter();

// Define routes
$router->get('/login', 'App\Controllers\UserController', 'showLoginForm');
$router->post('/login', 'App\Controllers\UserController', 'login');
$router->get('/signup', 'App\Controllers\UserController', 'signup');
$router->post('/signup', 'App\Controllers\UserController', 'signup');

// Dispatch the request
try {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $router->dispatch($requestUri);
} catch (Exception $e) {
    http_response_code(404);
    echo 'Page not found';
}