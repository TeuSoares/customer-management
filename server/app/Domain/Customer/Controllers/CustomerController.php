<?php

namespace Domain\Customer\Controllers;

use App\Core\Http\Controller;
use App\Core\Http\Middlewares\CheckIfUserIsAuthenticated;
use App\Core\Http\Request;
use App\Core\Http\Response;
use Domain\Customer\Services\CustomerService;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $service)
    {
        (new CheckIfUserIsAuthenticated)->handle();
    }

    public function index(): Response
    {
        $data = $this->service->getAllByUser();

        return $this->responseData(response(), $data);
    }

    public function show(Request $request): Response
    {
        $data = $this->service->show($request->getArguments()['id']);

        return $this->responseData(response(), $data);
    }

    public function store(Request $request): Response
    {
        $this->service->create($request->getParsedBody());

        return $this->responseMessage(response(), 'Cliente cadastrado com sucesso.');
    }

    public function update(Request $request): Response
    {
        $this->service->update($request->getArguments()['id'], $request->getParsedBody());

        return $this->responseMessage(response(), 'Cliente atualizado com sucesso.');
    }

    public function destroy(Request $request): Response
    {
        $this->service->delete($request->getArguments()['id']);

        return $this->responseMessage(response(), 'Cliente deletado com sucesso.');
    }
}
