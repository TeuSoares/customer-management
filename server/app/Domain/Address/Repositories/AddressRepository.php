<?php

namespace Domain\Address\Repositories;

use Domain\Address\Models\Address;
use PDOStatement;

class AddressRepository
{
    public function __construct(protected Address $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function getAllByCustomer(int $customer_id): array|false
    {
        $stmt = $this->model->read()
            ->where('customer_id = :customer_id')
            ->setParams([
                'customer_id' => $customer_id
            ])
            ->execute();

        return $stmt->fetch();
    }

    public function update(int $id, array $data): int
    {
        return $this->model->where('id = :id')
            ->update($data)
            ->setParams([
                'id' => $id,
                ...$data
            ])
            ->execute()
            ->rowCount();
    }

    public function delete(int $id): int
    {
        return $this->model->where('id = :id')
            ->delete()
            ->setParams([
                'id' => $id
            ])
            ->execute()
            ->rowCount();
    }
}
