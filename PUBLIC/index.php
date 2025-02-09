<?php
require_once __Dir__ . '/../vendor/autoload.php';


spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Rooter\SimpleRouter;
use App\Controller\CategorieController;

$router = new SimpleRouter();


$router->get('categories', CategorieController::class, 'categoriesDashboard');
$router->get('categories/create', CategorieController::class, 'createForm');
$router->post('categories/store', CategorieController::class, 'create');
$router->get('categories/edit/{id}', CategorieController::class, 'editForm');
$router->post('categories/update', CategorieController::class, 'update');
$router->get('categories/delete/{id}', CategorieController::class, 'delete');

$url = $_SERVER['REQUEST_URI'];

if (($pos = strpos($url, '?')) !== false) {
    $url = substr($url, 0, $pos);
}

$basePath = '/your-app-base-path';
$url = str_replace($basePath, '', $url);

try {
    $router->dispatch($url);
} catch (Exception $e) {
    http_response_code(404);
    echo "Page not found: " . $e->getMessage();
}
