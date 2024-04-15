<?php

namespace App\Support;

use App\Core\Exceptions\CustomException;

class Validation
{
    public static function required(array $data, ?array $requiredFields = null, ?array $message = null): void
    {
        $requiredFields = $requiredFields ?? array_keys($data);

        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field]))) {
                $msg = $message ?? [$field => "O campo {$field} é obrigatório."];

                self::throwException($msg);
            }
        }
    }

    public static function throwException(array $errors): void
    {
        throw new CustomException(
            [
                'validations' => $errors
            ],
            422
        );
    }
}
