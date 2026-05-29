<?php
namespace App\Middleware;

use Core\Http\Request;

class AuthMiddleware {
    public function handle(Request $request, callable $next) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_BASE_PATH . '/login');
            exit;
        }
        return $next($request);
    }
}