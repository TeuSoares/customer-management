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
        $data = $this->service->getAllByCustomer($request->getArgument('id'));

        return $this->responseData(response(), $data);
    }

    public function store(Request $request): Response
    {
        $this->service->create($request->getArgument('id'), $request->getParsedBody());

        return $this->responseMessage(response(), 'Endereço cadastrado com sucesso.');
    }

    public function destroy(Request $request): Response
    {
        $this->service->delete($request->getArgument('id'));

        return $this->responseMessage(response(), 'Endereço deletado com sucesso.');
    }
}
