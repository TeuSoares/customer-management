<?php

namespace App\Core\Http\Middlewares;

use App\Core\Providers\Container;
use App\Core\Traits\HandleExceptions;
use App\Support\Token;
use Domain\Auth\Repositories\PersonalAccessTokenRepository;

class CheckIfUserIsAuthenticated
{
    use HandleExceptions;

    public function handle(): void
    {
        if (!Token::checkIfTokenIsValid()) {
            $this->throwExceptionHttp('unauthenticated', 401);
        }

        $tokenRepository = (new Container)->make(PersonalAccessTokenRepository::class);

        $token = $tokenRepository->findOneByToken(request()->getAccessToken());

        if (!$token) {
            $this->throwExceptionHttp('unauthenticated', 401);
        }
    }
}
