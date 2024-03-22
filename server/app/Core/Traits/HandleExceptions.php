<?php

namespace App\Core\Traits;

use App\Core\Exceptions\CustomException;

trait HandleExceptions
{
    public function throwExceptionHttp(string|array $message, int $statusCode = 500)
    {
        throw new CustomException(
            [
                'message' => $message,
            ],
            $statusCode
        );
    }

    public function throwValidationException(array $errors): void
    {
        throw new CustomException(
            [
                'validations' => $errors
            ],
            422
        );
    }
}
