<?php

namespace Config;

class Routes{
    private static $routes = [
        'GET' => [
            '/' => ['App\Controllers\HomeController', 'index']],
        'POST' => [

        ],
        'PUT' => [

        ],
        'DELETE' => [

        ]
    ];

    public static function dispatch() {

        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        if (!isset(self::$routes[$method])) {
            http_response_code(405);
            die("Método HTTP {$method} não é suportado.");
        }

        if (isset(self::$routes[$method][$uri])) {

            $route = self::$routes[$method][$uri];
            $controllerClass = $route[0];
            $controllerMethod = $route[1];

            if (class_exists($controllerClass)) {
                if (method_exists($controllerClass, $controllerMethod)) {
                    return $controllerClass::$controllerMethod();
                }
            }
        }

        http_response_code(404);
        die("404 - Página não encontrada.");

    }

}