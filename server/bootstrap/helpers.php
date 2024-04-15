<?php

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Support\Token;

function dd(mixed ...$value): void
{
    var_dump($value);
    die();
}

function OnlyArrayOfStringKeys(array $array, int $offset): array
{
    $params = array_slice($array, $offset);

    return array_filter($params, function ($key) {
        return is_string($key);
    }, ARRAY_FILTER_USE_KEY);
}

function convertQueryStringToArray(string $queryString): array
{
    parse_str($queryString, $params);

    return $params;
}

function response(): Response
{
    return new Response;
}

function request(): Request
{
    return new Request;
}

function env(string $key): string
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    return $_ENV[$key];
}

function passwd_hash(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function passwd_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

function user(): object
{
    return Token::getData()->data;
}

function getContentFromFile(string $file): array
{
    return include $file;
}

function config(string $key): array
{
    $config = include __DIR__ . '/../config/app.php';

    return $config[$key];
}

function cleanInput(string $input)
{
    return preg_replace('/[^0-9]/', '', $input);
}
