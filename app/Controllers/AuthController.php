<?php
namespace App\Controllers;

use Core\View\Engine;

class AuthController {
    private Engine $view;

    public function __construct(Engine $view) {
        $this->view = $view;
    }

    public function showLoginForm(): void {
        $this->view->render('auth/login');
    }

    public function login(): void {
        session_start();
        $_SESSION['user'] = ['name' => 'demo'];
        header('Location: ' . APP_BASE_PATH . '/posts');
        exit;
    }
}