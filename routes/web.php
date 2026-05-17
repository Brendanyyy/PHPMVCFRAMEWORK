<?php
use App\Controllers\PostController;
use App\Middleware\AuthMiddleware;

$router->register('get', '/login', ['App\\Controllers\\AuthController', 'showLoginForm']);
$router->register('post', '/login', ['App\\Controllers\\AuthController', 'login']);

$router->register('get', '/posts', [PostController::class, 'index'], [AuthMiddleware::class]);
$router->register('get', '/posts/create', [PostController::class, 'create'], [AuthMiddleware::class]);
$router->register('post', '/posts', [PostController::class, 'store'], [AuthMiddleware::class]);
$router->register('get', '/posts/{id}/edit', [PostController::class, 'edit'], [AuthMiddleware::class]);
$router->register('post', '/posts/{id}/update', [PostController::class, 'update'], [AuthMiddleware::class]);
$router->register('post', '/posts/{id}/delete', [PostController::class, 'delete'], [AuthMiddleware::class]);