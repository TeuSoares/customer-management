<?php

namespace Domain\Address\Repositories;

use Domain\Address\Models\Address;
use PDOStatement;

class AddressRepository implements AddressRepositoryInterface
{
    public function __construct(protected Address $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function getAllByCustomer(int $customer_id): array
    {
        $stmt = $this->model->read('addresses.*')
            ->join('customers', 'customers.id', 'addresses.customer_id')
            ->join('users', 'users.id', 'customers.user_id')
            ->where('customer_id = :customer_id')
            ->where('customers.user_id = :user_id')
            ->setParams([
                'customer_id' => $customer_id,
                'user_id' => user()->id
            ])
            ->execute();

        return $stmt->fetchAll();
    }

    public function delete(int $id): int
    {
        return $this->model
            ->join('customers', 'customers.id', 'addresses.customer_id')
            ->join('users', 'users.id', 'customers.user_id')
            ->where('addresses.id = :id')
            ->where('customers.user_id = :user_id')
            ->delete()
            ->setParams([
                'id' => $id,
                'user_id' => user()->id
            ])
            ->execute()
            ->rowCount();
    }
}
