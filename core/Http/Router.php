<?php
namespace Core\Http;

use Core\Container\Container;
use ReflectionClass;

class Router {
    private array $routes = [];
    private ?Container $container = null;

    public function setContainer(Container $container): void {
        $this->container = $container;
    }

    public function register(string $method, string $uri, array $action, array $middleware = []): void {
        $this->routes[$method][$uri] = ['action' => $action, 'middleware' => $middleware];
    }

    public function resolve(string $method, string $uri) {
        [$route, $params] = $this->matchRoute($method, $uri);

        if ($route === null) {
            throw new \Exception("Route not found");
        }

        $action = $route['action'];
        $middlewareStack = $route['middleware'];

        $controllerCallable = function($request) use ($action, $params) {
            [$controllerClass, $method] = $action;

            $controller = $this->container
                ? $this->container->make($controllerClass)
                : new $controllerClass();

            $reflection = new ReflectionClass($controllerClass);
            $methodReflection = $reflection->getMethod($method);
            $arguments = [];

            foreach ($methodReflection->getParameters() as $parameter) {
                $type = $parameter->getType();
                if ($type && !$type->isBuiltin()) {
                    $typeName = $type->getName();
                    if ($typeName === Request::class) {
                        $arguments[] = $request;
                        continue;
                    }
                }

                $arguments[] = $params[$parameter->getName()] ?? ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null);
            }

            return $controller->$method(...$arguments);
        };

        $runner = array_reduce(
            array_reverse($middlewareStack),
            fn($next, $middlewareClass) => fn($request) => (new $middlewareClass())->handle($request, $next),
            $controllerCallable
        );

        return $runner(new Request());
    }

    private function matchRoute(string $method, string $uri): array {
        if (isset($this->routes[$method][$uri])) {
            return [$this->routes[$method][$uri], []];
        }

        foreach ($this->routes[$method] ?? [] as $routeUri => $route) {
            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routeUri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = is_numeric($value) ? (int) $value : $value;
                    }
                }

                return [$route, $params];
            }
        }

        return [null, []];
    }
}