<?php

namespace App\Middlewares;

class AuthMiddleware {

    public function handle(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    private function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
}