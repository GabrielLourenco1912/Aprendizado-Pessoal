<?php

namespace App\Middlewares;

class GuestMiddleware {

    public function handle(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }
    }

    private function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
}