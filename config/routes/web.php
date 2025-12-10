<?php

namespace config\routes;

use App\src\Controllers\AuthController;
use App\src\Controllers\HomeController;

/** @var \App\Core\Router $router */

$router->get('/auth/register', [HomeController::class, 'register']);

$router->get('/auth/login', [AuthController::class, 'login']);

$router->get('/', [HomeController::class, 'index']);