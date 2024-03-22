<?php

namespace App\Core\Exceptions;

class CustomException extends AbstractException
{
    public function __construct(
        string|array $message,
        int $statusCode = 200
    ) {
        parent::__construct($message, $statusCode);
    }
}
