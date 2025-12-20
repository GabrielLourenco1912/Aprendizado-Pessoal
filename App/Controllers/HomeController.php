<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class HomeController {
    public function index(Response $response): void {
        $response->json([
            'message' => 'Welcome to the Home Page!'
        ])->send();
    }
}