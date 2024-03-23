<?php

namespace Domain\Customer\Services;

use App\Core\Traits\HandleExceptions;
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
        $this->validateData($data);
        $this->validateUniqueCpf($data['cpf']);

        $data['user_id'] = user()->data->id;

        return $this->repository->create($data);
    }

    public function show(int $id): array
    {
        return $this->repository->getById($id);
    }

    public function getAllByUser(array $params = []): array|false
    {
        return $this->repository->getAllByUser(user()->data->id, $params);
    }

    public function update(int $id, array $data): void
    {
        $this->validateData($data);

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

    private function validateData(array $data): void
    {
        $requiredFields = ['name', 'birth_date', 'cpf', 'rg', 'phone'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("O campo {$field} é obrigatório.");
            }
        }
    }

    private function validateUniqueCpf(string $cpf): void
    {
        $existingCustomer = $this->repository->getByCpf($cpf);

        if ($existingCustomer) {
            throw new \RuntimeException('Cliente já cadastrado com este CPF.');
        }
    }
}
