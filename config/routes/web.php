<?php

namespace config\routes;

use App\Controllers\HomeController;

/** @var \App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);
