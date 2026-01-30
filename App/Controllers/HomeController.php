<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class HomeController {
    public function index(Response $response): void {
        $response->view('home/index')->send();
    }
}