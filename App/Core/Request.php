<?php

namespace App\Core;
class Request {
    public function getBody(): array {
        $method = $_SERVER['REQUEST_METHOD'];
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            return is_array($data) ? $data : [];
        }

        if ($method === 'POST') {
            return $_POST;
        }

        if (in_array($method, ['PUT', 'PATCH'])) {
            $input = file_get_contents('php://input');
            parse_str($input, $data);
            return $data;
        }

        return [];
    }
    public function getQueryParams(): array {
        return $_GET;
    }
}