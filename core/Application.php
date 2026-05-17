<?php
namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Router;
use Core\Container\Container;
use Core\View\Engine;

class Application {
    public Router $router;
    public Request $request;
    public Response $response;
    public Engine $view;
    public Container $container;

    public static Application $app;

    public function __construct(array $config = []) {
        self::$app = $this;

        // Initialize core components
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
        $this->container = new Container();

        // Set up view engine
        $viewPath = $config['view_path'] ?? __DIR__ . '/../app/Views';
        $this->view = new Engine($viewPath);

        // Set timezone if provided
        if (isset($config['timezone'])) {
            date_default_timezone_set($config['timezone']);
        }
    }

    /**
     * Bind a class or interface in the DI container
     */
    public function bind(string $abstract, $concrete) {
        $this->container->bind($abstract, $concrete);
    }

    /**
     * Run the application
     */
    public function run(): void {
        try {
            $this->router->resolve($this->request->getMethod(), $this->request->getPath());
        } catch (\Exception $e) {
            $this->response->send("Error: " . $e->getMessage());
        }
    }

    /**
     * Resolve a class from the container
     */
    public function make(string $class) {
        return $this->container->make($class);
    }
}