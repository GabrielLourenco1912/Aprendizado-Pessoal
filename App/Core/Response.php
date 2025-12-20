<?php

namespace App\Core;

class Response {
    private int $statusCode = 200;
    private array $headers = [];
    private mixed $content = null;

    public function setStatusCode(int $code): self {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader(string $key, string $value): self {
        $this->headers[$key] = $value;
        return $this;
    }

    public function setContent(mixed $content): self {
        $this->content = $content;
        return $this;
    }

    public function json(array $data, int $code = 200): self {
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatusCode($code);
        $this->content = json_encode($data);
        return $this;
    }
    public function view(string $viewName, array $data = []): self {
        $viewPath = __DIR__ . '/../../views/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            $this->setStatusCode(500);
            $this->setContent("Erro: View '$viewName' não encontrada.");
            return $this;
        }

        extract($data);

        ob_start();

        require $viewPath;

        $content = ob_get_clean();

        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
        $this->setContent($content);

        return $this;
    }

    public function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    public function send(): void {
        http_response_code($this->statusCode);

            foreach ($this->headers as $key => $value) {
                header("$key: $value");
            }

        echo $this->content;
    }
}