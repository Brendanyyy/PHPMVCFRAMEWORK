<?php
namespace Core\Http;

class Request {
    public function getPath(): string {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

        if (defined('APP_BASE_PATH') && APP_BASE_PATH !== '' && str_starts_with($path, APP_BASE_PATH)) {
            $path = substr($path, strlen(APP_BASE_PATH));
            if ($path === '') {
                $path = '/';
            }
        }

        return $path;
    }

    public function getMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function all(): array {
        return $_REQUEST;
    }
}