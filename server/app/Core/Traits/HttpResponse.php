<?php

namespace App\Core\Traits;

use App\Core\Http\Response;

trait HttpResponse
{
    public function responseData(Response $response, array $data, int $statusCode = 200): Response
    {
        return $response->withStatus($statusCode)->json(['data' => $data]);
    }

    public function responseMessage(Response $response, string $message, int $statusCode = 200): Response
    {
        return $response->withStatus($statusCode)->json(['message' => $message]);
    }

    public function responseMessageWithData(Response $response, string $message, array $data, int $statusCode = 200): Response
    {
        return $response->withStatus($statusCode)->json(['message' => $message, 'data' => $data]);
    }
}
