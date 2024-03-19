<?php

namespace App\Support;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class Token
{
    private static ?object $data = null;

    public static function createToken(array $data, int $expires): string
    {
        $payload = [
            "exp" => $expires,
            "data" => $data,
            "iat" => time()
        ];

        return JWT::encode($payload, env('TOKEN_KEY'), 'HS256');
    }

    public static function checkIfTokenIsValid(): bool
    {
        $authorization = request()->getAccessToken();

        if (!$authorization) {
            return false;
        }

        $token = base64_decode($authorization);

        try {
            $decoded = JWT::decode($token, new Key(env('TOKEN_KEY'), 'HS256'));

            self::$data = $decoded;

            return true;
        } catch (Throwable $e) {
            if ($e->getMessage() === 'Expired token') {
                return false;
            }
        }
    }

    public static function getData(): object
    {
        return self::$data;
    }
}
