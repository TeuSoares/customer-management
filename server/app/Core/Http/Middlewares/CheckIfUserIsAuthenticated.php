<?php

namespace App\Core\Http\Middlewares;

use App\Core\Http\Middlewares\Interfaces\MiddlewareInterface;
use App\Core\Providers\Container;
use App\Core\Traits\HandleExceptions;
use App\Support\Token;
use Domain\Auth\Repositories\PersonalAccessTokenRepository;

class CheckIfUserIsAuthenticated implements MiddlewareInterface
{
    use HandleExceptions;

    public function handle(): void
    {
        if (!Token::checkIfTokenIsValid()) {
            $this->throwExceptionHttp('Não está autenticado.', 401);
        }

        $tokenRepository = (new Container)->make(PersonalAccessTokenRepository::class);

        $token = $tokenRepository->findOneByToken(request()->getAccessToken());

        if (!$token) {
            $this->throwExceptionHttp('Não está autenticado.', 401);
        }
    }
}
