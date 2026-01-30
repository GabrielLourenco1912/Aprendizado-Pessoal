<?php

namespace config\routes;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\BDController;

/** @var \App\Core\Router $router */

$router->group(['middleware' => 'guest'], function($r) {;
    $r->get('/auth/register', [AuthController::class, 'register']);
    $r->get('/auth/login', [AuthController::class, 'login']);
});;

$router->get('/', [HomeController::class, 'index']);

$router->get('/bd/schemaBuilder', [BDController::class, 'schemaBuilder']);

$router->post('/bd/schemaBuilder', [BDController::class, 'schemaBuilderGenerate']);

$router->group(['middleware' => 'auth'], function($r) {
    $r->get('/dashboard', [HomeController::class, 'dashboard']);
});