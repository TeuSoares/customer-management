<?php

namespace App\Core\Http\Routes;

use App\Core\Providers\Container;
use App\Core\Traits\HandleExceptions;

class Router
{
    use HandleExceptions;

    public static self $instance;

    public function __construct(
        private Routes $routes,
        private MiddlewareDispatcher $middlewareDispatcher
    ) {
    }

    public static function singleInstance(): self
    {
        if (empty(self::$instance)) {
            $routes = new Routes();
            $middlewareDispatcher = new MiddlewareDispatcher($routes);

            self::$instance = new static($routes, $middlewareDispatcher);
        }

        return self::$instance;
    }

    public function __call(string $method, array $arguments)
    {
        if (method_exists($this->routes, $method)) {
            call_user_func_array([$this->routes, $method], $arguments);
            return $this;
        }

        if (method_exists($this->middlewareDispatcher, $method)) {
            call_user_func_array([$this->middlewareDispatcher, $method], $arguments);
            return $this;
        }

        throw new \BadMethodCallException("Method $method does not exist");
    }

    public function dispatch(): void
    {
        $request_uri = $_SERVER['REQUEST_URI'];

        $parsed_url = parse_url($request_uri);

        $path = $parsed_url['path'];

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->sendOptionsResponse();
            return;
        }

        $this->sendCorsHeaders();

        foreach ($this->routes->routes as $route => $actions) {
            // Verifica se a URL da rota corresponde à URL da requisição
            if (preg_match($this->convertToRegex($route), $path, $matches)) {
                $this->middlewareDispatcher->runGroupMiddleware($route);

                foreach ($actions as $action) {
                    if ($_SERVER['REQUEST_METHOD'] == $action['method']) {
                        $this->middlewareDispatcher->runMiddleware($action['middleware']);

                        $this->executeCallback($action['callback'], $matches);
                        return;
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

    private function executeCallback(callable|string $callback, array $params): void
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
