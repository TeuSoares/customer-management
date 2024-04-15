<?php

namespace App\Core\Traits;

use App\Core\Exceptions\CustomException;

trait HandleExceptions
{
    public function throwExceptionHttp(string|array $message, int $statusCode = 500): void
    {
        throw new CustomException(
            [
                'message' => $message,
            ],
            $statusCode
        );
    }
}
