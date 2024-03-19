<?php

namespace Domain\Auth\Services;

use App\Core\Http\Middlewares\CheckIfUserIsAuthenticated;
use App\Core\Traits\HandleExceptions;
use App\Support\Token;
use Domain\Auth\Repositories\PersonalAccessTokenRepository;
use Domain\User\Repositories\UserRepository;

class AuthService
{
    use HandleExceptions;

    public function __construct(
        private UserRepository $userRepository,
        private PersonalAccessTokenRepository $tokenRepository
    ) {
    }

    public function login(array $data): string
    {
        if (!isset($data['email']) || !isset($data['password'])) {
            $this->throwValidationException(['auth_login' => 'Todos os campos são obrigatórios.']);
        }

        $user = $this->userRepository->findOneByEmail($data['email']);

        if (!$user || !passwd_verify($data['password'], $user['password'])) {
            $this->throwValidationException(['user' => 'Usuário e(ou) senha incorretos.']);
        }

        $expireInOneDay = time() + (1 * 24 * 60 * 60);

        $token = base64_encode(Token::createToken($user, $expireInOneDay));

        $this->tokenRepository->create([
            'user_id' => $user['id'],
            'token' => $token,
            'access' => 'user',
            'expire' => $expireInOneDay
        ]);

        return $token;
    }

    public function logout(): void
    {
        (new CheckIfUserIsAuthenticated)->handle();

        $this->tokenRepository->delete(request()->getAccessToken());
    }

    public function register(array $data): void
    {
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            $this->throwValidationException(['auth_register' => 'Todos os campos são obrigatórios.']);
        }

        $user = $this->userRepository->findOneByEmail($data['email']);

        if ($user) {
            $this->throwValidationException(['email' => 'Esse e-mail já está em uso.']);
        }

        $data['password'] = passwd_hash($data['password']);

        $this->userRepository->create($data);
    }
}
