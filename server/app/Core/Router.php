<?php

namespace App\Core;

use App\Core\Traits\HandleExceptions;

class Router
{
    use HandleExceptions;

    private array $routes = [];

    private function setRoutes(string $url, string $method, callable|string $callback)
    {
        if (!isset($this->routes[$url])) {
            $this->routes[$url] = [];
        }

        array_push($this->routes[$url], [
            "method" => $method,
            "callback" => $callback
        ]);
    }

    public function get(string $url, callable|string $callback): void
    {
        $this->setRoutes($url, 'GET', $callback);
    }

    public function post(string $url, callable|string $callback): void
    {
        $this->setRoutes($url, 'POST', $callback);
    }

    public function put(string $url, callable|string $callback): void
    {
        $this->setRoutes($url, 'PUT', $callback);
    }

    public function delete(string $url, callable|string $callback): void
    {
        $this->setRoutes($url, 'DELETE', $callback);
    }

    public function dispatch(): mixed
    {
        $path = $_SERVER['PATH_INFO'];

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            return $this->sendOptionsResponse();
        }

        foreach ($this->routes as $route => $actions) {
            // Verifica se a URL da rota corresponde à URL da requisição
            if (preg_match($this->convertToRegex($route), $path, $matches)) {
                foreach ($actions as $action) {
                    if ($_SERVER['REQUEST_METHOD'] == $action['method']) {
                        $this->sendCorsHeaders();
                        return $this->executeCallback($action['callback'], $matches);
                    }
                }

                $this->throwExceptionHttp("Esse método não é suportado para essa rota.", 405);
            }
        }

        $this->throwExceptionHttp("Rota não está definida.", 404);
    }

    private function convertToRegex(string $route): string
    {
        // Converte a URL da rota para uma expressão regular
        $routePattern = preg_replace('/\{([^}]+)\}/', '(?<$1>[^/]+)', $route);
        return "/^" . str_replace('/', '\/', $routePattern) . "$/";
    }

    private function executeCallback(callable|string $callback, array $params): mixed
    {
        $request = request()->setArguments($params);

        if (is_callable($callback)) {
            $response = call_user_func($callback, $request);

            $response->send();
        }

        $callback = explode('@', $callback);
        $controller = $callback[0];
        $method = $callback[1];

        $container = new Container;

        $response = call_user_func([$container->make($controller), $method], $request);

        $response->send();
    }

    private function sendCorsHeaders(): void
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Credentials: true");
    }

    private function sendOptionsResponse(): void
    {
        $this->sendCorsHeaders();
        header("HTTP/1.1 200 OK");
    }
}
