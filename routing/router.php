<?php
namespace App\Rooter;




class SimpleRouter {
    private $routes = [];

    public function get($url, $controller, $action) {
        $this->routes['GET'][$url] = ['controller' => $controller, 'action' => $action];
    }

    public function post($url, $controller, $action) {
        $this->routes['POST'][$url] = ['controller' => $controller, 'action' => $action];
    }

    private function matchRoute($routeUrl, $requestUrl) {
        $routeParts = explode('/', trim($routeUrl, '/'));
        $requestParts = explode('/', trim($requestUrl, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        $params = [];
        foreach ($routeParts as $i => $part) {
            if (strpos($part, '{') === 0) {
                $params[trim($part, '{}')] = $requestParts[$i];
            } elseif ($part !== $requestParts[$i]) {
                return false;
            }
        }
        return $params;
    }


    

    public function dispatch($url) {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = trim($url, '/');

        foreach ($this->routes[$method] ?? [] as $routeUrl => $route) {
            $params = $this->matchRoute($routeUrl, $url);
            if ($params !== false) {
                $controllerName = $route['controller'];
                $action = $route['action'];

                $controller = new $controllerName();
                return $controller->$action($params);
            }
        }

        throw new Exception('No route found');
    }
}
