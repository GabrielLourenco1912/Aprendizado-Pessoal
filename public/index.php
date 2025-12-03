<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

$router->setPrefix('/api');

require __DIR__ . '/../config/routes/api.php';

$router->setPrefix('');

require __DIR__ . '/../config/routes/web.php';

$router->dispatch();
