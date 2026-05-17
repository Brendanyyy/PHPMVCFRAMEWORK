<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Http\Request;
use Core\Http\Router;
use Core\View\Engine;
use Core\Database\Connection;
use Core\Container\Container;
use App\Models\Post;
use App\Controllers\PostController;

// Load configs
$dbConfig = require __DIR__ . '/../config/database.php';
$appConfig = require __DIR__ . '/../config/app.php';

// Set timezone
date_default_timezone_set($appConfig['timezone']);

// Database connection
$db = new Connection($dbConfig);

// Request and Router
$request = new Request();
$router = new Router();
$view = new Engine($appConfig['view_path']);
$container = new Container();
$container->bind(Connection::class, $db);
$container->bind(Engine::class, $view);
$router->setContainer($container);

// Routes
require_once __DIR__ . '/../routes/web.php';

// Resolve request
$router->resolve($request->getMethod(), $request->getPath());