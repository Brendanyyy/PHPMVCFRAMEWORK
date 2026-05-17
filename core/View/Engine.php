<?php
namespace Core\View;

class Engine {
    private string $viewPath;

    public function __construct(string $viewPath) {
        $this->viewPath = rtrim($viewPath, '/');
    }

    public function render(string $view, array $params = []): void {
        extract($params);
        $file = $this->viewPath . '/' . $view . '.php';
        if (!file_exists($file)) {
            throw new \Exception("View file {$file} not found");
        }
        include $file;
    }
}