<?php

namespace Domain\Auth\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use Domain\Auth\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {
    }

    public function login(Request $request): Response
    {
        $token = $this->service->login($request->getParsedBody());

        return $this->responseMessageWithData(response(), "Usuário autenticado com sucesso.", ['token' => $token]);
    }

    public function logout(): Response
    {
        $this->service->logout();

        return $this->responseMessage(response(), "Usuário desconectado com sucesso.");
    }

    public function register(Request $request): Response
    {
        $this->service->register($request->getParsedBody());

        return $this->responseMessage(response(), "Usuário cadastrado com sucesso.");
    }
}
