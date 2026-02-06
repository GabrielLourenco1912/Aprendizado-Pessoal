<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

use App\Core\Router;
use App\Core\Response;
use App\Core\Exceptions\HttpException;

$router = new Router();

$router->setPrefix('/api');

require __DIR__ . '/../config/routes/api.php';

$router->setPrefix('');

require __DIR__ . '/../config/routes/web.php';

try {
    $router->dispatch();
} catch (HttpException $e) {
    $response = new Response();
    $response->setStatusCode($e->getStatusCode())
        ->view('errors/error', ['code' => $e->getStatusCode(), 'message' => $e->getMessage()])->send();
} catch (\Throwable $e) {
    $response = new Response();
    $response->setStatusCode($e->getCode())
        ->view('errors/error', ['code' => 500, 'message' => $e->getMessage()])->send();
}