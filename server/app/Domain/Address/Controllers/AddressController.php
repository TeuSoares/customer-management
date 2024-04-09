<?php

namespace Domain\Address\Controllers;

use App\Core\Http\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use Domain\Address\Services\AddressService;

class AddressController extends Controller
{
    public function __construct(protected AddressService $service)
    {
    }

    public function index(Request $request): Response
    {
        $data = $this->service->getAllByCustomer($request->getArguments()['id']);

        return $this->responseData(response(), $data);
    }

    public function store(Request $request): Response
    {
        $this->service->create($request->getArguments()['id'], $request->getParsedBody());

        return $this->responseMessage(response(), 'Endereço cadastrado com sucesso.');
    }

    public function update(Request $request): Response
    {
        $this->service->update($request->getArguments()['id'], $request->getParsedBody());

        return $this->responseMessage(response(), 'Endereço atualizado com sucesso.');
    }

    public function destroy(Request $request): Response
    {
        $this->service->delete($request->getArguments()['id']);

        return $this->responseMessage(response(), 'Endereço deletado com sucesso.');
    }
}
