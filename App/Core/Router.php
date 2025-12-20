<?php

namespace App\Core;

class Router {
    private array $routes = [];
    private array $currentMiddlewares = [];
    private string $prefix = '';
    public function setPrefix(string $prefix) {
        $this->prefix = $prefix;
    }
    public function get(string $path, array $handler) {
        $this->addRoute('GET', $path, $handler);
    }
    public function post(string $path, array $handler) {
        $this->addRoute('POST', $path, $handler);
    }
    public function put(string $path, array $handler) {
        $this->addRoute('PUT', $path, $handler);
    }
    public function delete(string $path, array $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }
    public function group(array $options, callable $callback) {
        $previousMiddlewares = $this->currentMiddlewares;

        if (isset($options['middleware'])) {
            $middlewares = (array) $options['middleware'];
            $this->currentMiddlewares = array_merge($this->currentMiddlewares, $middlewares);
        }

        $callback($this);

        $this->currentMiddlewares = $previousMiddlewares;
    }
    private function addRoute(string $method, string $path, array $handler) {
        $path = $this->prefix . $path;
        $path = '/' . trim($path, '/');

        $this->routes[$method][$path] = [
            'handler' => $handler,
            'middlewares' => $this->currentMiddlewares
        ];
    }
    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = '/' . trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo "405 - Método não permitido";
            return;
        }

        if (isset($this->routes[$method][$uri])) {
            $this->executeMiddleware($this->routes[$method][$uri]);
            $this->executeHandler($this->routes[$method][$uri]);
            return;
        }

        foreach ($this->routes[$method] as $route => $handler) {
            if (strpos($route, '{') === false) {
                continue;
            }

            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->executeMiddleware($handler);
                $this->executeHandler($handler, $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Não encontrado";
    }

    private function executeHandler(array $handler, array $params = []) {
        $controllerClass = $handler['handler'][0];
        $controllerMethod = $handler['handler'][1];

        if (!class_exists($controllerClass)) return;

        $controllerInstance = new $controllerClass;

        if (!method_exists($controllerInstance, $controllerMethod)) return;

        $request = new \App\Core\Request();
        $response = new \App\Core\Response();

        $reflector = new \ReflectionMethod($controllerInstance, $controllerMethod);
        $parameters = $reflector->getParameters();

        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                if ($typeName === \App\Core\Request::class) {
                    $dependencies[] = $request;
                } elseif ($typeName === \App\Core\Response::class) {
                    $dependencies[] = $response;
                }
            } else {
                if (!empty($urlParams)) {
                    $dependencies[] = array_shift($urlParams);
                }
            }
        }

        $controllerInstance->$controllerMethod(...$dependencies);
    }

    private function executeMiddleware(array $routeData)
    {
        foreach ($routeData['middlewares'] as $middlewareKey) {
            $middlewareClass = $this->resolveMiddleware($middlewareKey);

            (new $middlewareClass)->handle();
        }
    }

    private function resolveMiddleware(string $key): string {
        $map = [
            'auth' => \App\Middlewares\AuthMiddleware::class,
            'guest' => \App\Middlewares\GuestMiddleware::class
        ];
        return $map[$key] ?? $key;
    }
}