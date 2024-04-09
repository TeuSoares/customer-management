<?php

namespace App\Core\Http\Routes;

use App\Core\Http\Kernel;
use App\Core\Http\Middlewares\Interfaces\MiddlewareInterface;
use App\Core\Traits\HandleExceptions;

class MiddlewareDispatcher
{
    use HandleExceptions;

    private array $groupMiddleware = [];

    public function __construct(protected Routes $routes)
    {
    }

    public function middleware(array $middlewares): void
    {
        $routeKeys = array_keys($this->routes->routes);

        $lastRouteKey = end($routeKeys);

        $route = $this->routes->routes[$lastRouteKey];

        $lastKey = array_key_last($route);

        $this->routes->routes[$lastRouteKey][$lastKey]['middleware'] = $middlewares;
    }

    public function addGroupMiddleware(array $middlewares): void
    {
        $this->groupMiddleware[$this->routes->currentPrefix] = $middlewares;
    }

    public function runMiddleware(array $middleware): void
    {
        if (!empty($middleware)) {
            foreach ($middleware as $value) {
                $this->dispatch($value);
            }
        }
    }

    public function runGroupMiddleware(string $route): void
    {
        if (!empty($this->groupMiddleware)) {
            foreach ($this->groupMiddleware as $key => $middleware) {
                if (strpos($route, $key) !== false) {
                    foreach ($middleware as $value) {
                        $this->dispatch($value);
                    }
                }
            }
        }
    }

    private function dispatch(string $middleware): void
    {
        $kernel = new Kernel;

        $allMiddleware = $kernel->getMiddleware();

        if (!empty($allMiddleware)) {
            $keys = array_keys($allMiddleware);

            if (in_array($middleware, $keys)) {
                $middleware = $allMiddleware[$middleware];
            }
        }

        if (class_exists($middleware)) {
            $middlewareInstance = new $middleware;

            if ($middlewareInstance instanceof MiddlewareInterface) {
                $middlewareInstance->handle();
                return;
            }

            $this->throwExceptionHttp("A classe $middleware precisa implementar a interface MiddlewareInterface");
        }

        $this->throwExceptionHttp("Não foi possível encontrar a classe $middleware", 404);
    }
}
