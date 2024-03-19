<?php

namespace App\Core\Http\Middlewares;

use App\Support\Token;
use Domain\Auth\Models\PersonalAccessToken;
use Domain\Auth\Repositories\PersonalAccessTokenRepository;

class CheckIfUserIsAuthenticated
{
    public function handle(): void
    {
        if (!Token::checkIfTokenIsValid()) {
            header('Content-Type: application/json');
            http_response_code(401);
            die(json_encode(['message' => 'unauthenticated']));
        }

        $personalAccessToken = new PersonalAccessToken;

        $tokenRepository = new PersonalAccessTokenRepository($personalAccessToken);

        $token = $tokenRepository->findOneByToken(request()->getAccessToken());

        if (!$token) {
            header('Content-Type: application/json');
            http_response_code(401);
            die(json_encode(['message' => 'unauthenticated']));
        }
    }
}
