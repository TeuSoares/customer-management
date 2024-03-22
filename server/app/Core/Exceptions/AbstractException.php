<?php

namespace App\Core\Exceptions;

use Exception;

abstract class AbstractException extends Exception
{
    public function __construct(
        protected string|array $messageException,
        protected int $statusCode = 200
    ) {
    }

    public function throwWithMessage(): string
    {
        header('Content-Type: application/json');

        http_response_code($this->statusCode);

        return json_encode($this->messageException);
    }
}
