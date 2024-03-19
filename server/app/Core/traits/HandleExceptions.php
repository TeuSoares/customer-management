<?php

namespace App\Core\Traits;

trait HandleExceptions
{
    public function throwExceptionHttp(string $message, int $statusCode = 500)
    {
        http_response_code($statusCode);
        throw new \Exception(json_encode(
            [
                'error' => [
                    'message' => $message,
                ]
            ]
        ));
    }

    public function throwValidationException(array $errors): void
    {
        http_response_code(422);
        throw new \Exception(json_encode(
            [
                'errors' => $errors
            ]
        ));
    }
}
