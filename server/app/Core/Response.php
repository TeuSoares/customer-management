<?php

namespace App\Core;

class Response
{
    private array $body = [];
    private array $headers = [];
    private $statusCode = 200;

    public function json(array $data): self
    {
        $this->body = $data;

        return $this;
    }

    public function noContent(): self
    {
        $this->statusCode = 204;

        return $this;
    }

    public function withStatus(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function withHeader(string $name, string $value): self
    {
        array_push($this->headers, ['name' => $name, 'value' => $value]);

        return $this;
    }

    public function send()
    {
        header('Content-Type: application/json');

        http_response_code($this->statusCode);

        if (count($this->headers)) {
            foreach ($this->headers as $header) {
                header($header['name'] . ': ' . $header['value']);
            }
        }

        die(json_encode($this->body));
    }
}
