<?php

namespace Domain\Address\Services;

use App\Core\Traits\HandleExceptions;
use Domain\Address\Repositories\AddressRepositoryInterface;
use PDOStatement;

class AddressService
{
    use HandleExceptions;

    public function __construct(protected AddressRepositoryInterface $repository)
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

    public function delete(int $id): void
    {
        if (!$this->repository->delete($id)) {
            $this->throwExceptionHttp('Não foi possível	deletar. Verifique o endereço e tende novamente!');
        }
    }

    private function validateData(array $data): void
    {
        $requiredFields = ['street_address', 'neighborhood', 'number', 'city', 'state'];

        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field]))) {
                $this->throwValidationException([$field => "O campo {$field} é obrigatório."]);
            }
        }
    }
}
