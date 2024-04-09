<?php

namespace App\Core\Http\Routes;

class Routes
{
    public array $routes = [];
    public string $currentPrefix = '';

    private function addRoute(string $url, string $method, callable|string $callback): void
    {
        if (!isset($this->routes[$url])) {
            $this->routes[$url] = [];
        }

        array_push($this->routes[$url], [
            "method" => $method,
            "callback" => $callback,
            "middleware" => []
        ]);
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->currentPrefix = $prefix;
        $boundCallback = ((object)$callback)->bindTo(Router::singleInstance(), null); // Vincula a instância única de Router ao contexto do callback
        $boundCallback(); // Chama o callback vinculado
    }

    public function get(string $url, callable|string $callback): void
    {
        $this->addRoute($this->currentPrefix . $url, 'GET', $callback);
    }

    public function post(string $url, callable|string $callback): void
    {
        $this->addRoute($this->currentPrefix . $url, 'POST', $callback);
    }

    public function put(string $url, callable|string $callback): void
    {
        $this->addRoute($this->currentPrefix . $url, 'PUT', $callback);
    }

    public function delete(string $url, callable|string $callback): void
    {
        $this->addRoute($this->currentPrefix . $url, 'DELETE', $callback);
    }
}
