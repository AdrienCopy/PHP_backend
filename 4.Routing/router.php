<?php

class Router {
    private $routes = [];

    public function addRoute($method, $route, $handler) {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'handler' => $handler,
        ];
    }

    public function run() {
        $requestedMethod = $_SERVER['REQUEST_METHOD'];
        $requestedUri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestedMethod && preg_match($this->convertToRegex($route['route']), $requestedUri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        // If no route was matched, show a 404 page
        http_response_code(404);
        echo "404 Not Found";
    }

    private function convertToRegex($route) {
        return '@^' . preg_replace('@{([^}]+)}@', '([^/]+)', $route) . '$@';
    }
}

