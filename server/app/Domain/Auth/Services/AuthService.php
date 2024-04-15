<?php

namespace Domain\Auth\Services;

use App\Core\Traits\HandleExceptions;
use App\Support\Token;
use App\Support\Validation;
use Domain\Auth\Repositories\PersonalAccessTokenRepository;
use Domain\User\Repositories\UserRepositoryInterface;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PersonalAccessTokenRepository $tokenRepository
    ) {
    }

    public function login(array $data): string
    {
        Validation::required(data: $data, message: ['required' => 'Todos os campos são obrigatórios.']);

        $user = $this->userRepository->findOneByEmail($data['email']);

        if (!$user || !passwd_verify($data['password'], $user['password'])) {
            Validation::throwException(['user' => 'Usuário e(ou) senha incorretos.']);
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
        $this->tokenRepository->delete(request()->getAccessToken());
    }

    public function register(array $data): void
    {
        Validation::required(data: $data, message: ['required' => 'Todos os campos são obrigatórios.']);

        $user = $this->userRepository->findOneByEmail($data['email']);

        if ($user) {
            Validation::throwException(['email' => 'Esse e-mail já está em uso.']);
        }

        $data['password'] = passwd_hash($data['password']);

        $this->userRepository->create($data);
    }
}
