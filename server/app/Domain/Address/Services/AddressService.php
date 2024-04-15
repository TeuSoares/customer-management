<?php

namespace Domain\Address\Services;

use App\Core\Traits\HandleExceptions;
use App\Support\Validation;
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
        Validation::required($data);

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
}
