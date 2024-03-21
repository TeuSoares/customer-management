<?php

namespace Domain\Address\Services;

use App\Core\Traits\HandleExceptions;
use Domain\Address\Repositories\AddressRepository;
use PDOStatement;

class AddressService
{
    use HandleExceptions;

    public function __construct(protected AddressRepository $repository)
    {
    }

    public function create(int $customer_id, array $data): PDOStatement
    {
        $this->validateData($data);

        $data['customer_id'] = $customer_id;

        return $this->repository->create($data);
    }

    public function getAllByCustomer(int $customer_id): array
    {
        return $this->repository->getAllByCustomer($customer_id);
    }

    public function update(int $id, array $data): void
    {
        $this->validateData($data);

        if (!$this->repository->update($id, $data)) {
            $this->throwExceptionHttp('Não foi possível	atualizar. Verifique o endereço e tende novamente!');
        }
    }

    public function delete(int $id): void
    {
        if (!$this->repository->delete($id)) {
            $this->throwExceptionHttp('Não foi possível	deletar. Verifique o endereço e tende novamente!');
        }
    }

    private function validateData(array $data): void
    {
        $requiredFields = ['address', 'number', 'city', 'state'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("O campo {$field} é obrigatório.");
            }
        }
    }
}
