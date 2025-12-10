<?php

namespace App\Core;

class Router {
    private array $routes = [];
    private string $prefix = '';

    public function setPrefix(string $prefix) {
        $this->prefix = $prefix;
    }

    public function get(string $path, $handler) {
        $path = $this->prefix . $path;
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];

            $controllerClass =  $handler[0];
            $controllerMethod = $handler[1];

            if (class_exists($controllerClass)) {
                $controller =  new $controllerClass;
                if (method_exists($controller, $controllerMethod)) {
                    $handler = [$controller, $controllerMethod];
                    call_user_func($handler);
                }
            }

        } else {
            http_response_code(404);
            echo "404 - Não encontrado";
        }
    }
}