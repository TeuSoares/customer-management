<?php

namespace Domain\Customer\Services;

use App\Core\Traits\HandleExceptions;
use App\Support\Validation;
use Domain\Customer\Repositories\CustomerRepositoryInterface;
use PDOStatement;

class CustomerService
{
    use HandleExceptions;

    public function __construct(protected CustomerRepositoryInterface $repository)
    {
    }

    public function create(array $data): PDOStatement
    {
        Validation::required($data);
        $this->validateUniqueCpf($data['cpf']);

        $data['user_id'] = user()->id;

        $data['cpf'] = cleanInput($data['cpf']);
        $data['rg'] = cleanInput($data['rg']);
        $data['phone'] = cleanInput($data['phone']);

        return $this->repository->create($data);
    }

    public function show(int $id): array
    {
        if ($customer = $this->repository->getById($id)) {
            return $customer;
        }

        $this->throwExceptionHttp('Não foi possível localizar esse cliente!', 404);
    }

    public function getAllByUser(array $params = []): array|false
    {
        return $this->repository->getAllByUser(user()->id, $params);
    }

    public function update(int $id, array $data): void
    {
        Validation::required($data);

        $data['cpf'] = cleanInput($data['cpf']);
        $data['rg'] = cleanInput($data['rg']);
        $data['phone'] = cleanInput($data['phone']);

        if (!$this->repository->update($id, $data)) {
            $this->throwExceptionHttp('Não foi possível	atualizar. Verifique o cliente e tende novamente!');
        }
    }

    public function delete(int $id): void
    {
        if (!$this->repository->delete($id)) {
            $this->throwExceptionHttp('Não foi possível	deletar. Verifique o cliente e tende novamente!');
        }
    }

    private function validateUniqueCpf(string $cpf): void
    {
        $existingCustomer = $this->repository->getByCpf(cleanInput($cpf));

        if ($existingCustomer) {
            Validation::throwException(['cpf' => 'Cliente já cadastrado com este CPF.']);
        }
    }
}
