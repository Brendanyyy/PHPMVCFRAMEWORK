<?php
namespace Core\Container;

class Container {
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $abstract, $concrete): void {
        $this->bindings[$abstract] = $concrete;
    }

    public function make(string $abstract) {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract] instanceof \Closure) {
            $object = $this->bindings[$abstract]($this);
        } else if (isset($this->bindings[$abstract]) && is_object($this->bindings[$abstract])) {
            $object = $this->bindings[$abstract];
        } else if (isset($this->bindings[$abstract])) {
            $object = $this->build($this->bindings[$abstract]);
        } else {
            $object = $this->build($abstract);
        }

        $this->instances[$abstract] = $object;
        return $object;
    }

    private function build(string $class) {
        $reflector = new \ReflectionClass($class);
        if (!$reflector->getConstructor()) {
            return new $class();
        }

        $params = $reflector->getConstructor()->getParameters();
        $dependencies = [];
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->make($type->getName());
            } else {
                $dependencies[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}