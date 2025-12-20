<?php

namespace config\routes;

use App\Controllers\AuthController;
use App\Controllers\HomeController;

/** @var \App\Core\Router $router */

$router->group(['middleware' => 'guest'], function($r) {;
    $r->get('/auth/register', [AuthController::class, 'register']);
    $r->get('/auth/login', [AuthController::class, 'login']);
});;

$router->get('/', [HomeController::class, 'index']);

$router->group(['middleware' => 'auth'], function($r) {
    $r->get('/dashboard', [HomeController::class, 'dashboard']);
});