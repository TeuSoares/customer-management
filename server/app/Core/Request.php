<?php

namespace App\Core;

class Request
{
    private array $arguments = [];

    public function setArguments(array $params): self
    {
        $this->arguments = OnlyArrayOfStringKeys($params, 1);

        return $this;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getParsedBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function getQueryParams(): array
    {
        return convertQueryStringToArray($_SERVER['QUERY_STRING']);
    }

    public function getServerParams(): array
    {
        return $_SERVER;
    }

    public function getAllHeaders(): array
    {
        return getallheaders();
    }

    public function getHeader(string $name): ?string
    {
        return getallheaders()[$name] ?? null;
    }

    public function hasHeader(string $name): bool
    {
        return isset(getallheaders()[$name]);
    }

    public function getAccessToken(): ?string
    {
        $token = $this->getHeader('Authorization');

        if ($token) {
            return str_replace('Bearer ', '', $token);
        }

        return null;
    }
}
