<?php

namespace Domain\Customer\Repositories;

use Domain\Customer\Models\Customer;
use PDOStatement;

class CustomerRepository
{
    public function __construct(protected Customer $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function getAllByUser(int $user_id, array $params = []): array|false
    {
        $stmt = $this->model->read()
            ->where('user_id = :user_id')
            ->setParams([
                'user_id' => $user_id
            ])
            ->execute();

        return $stmt->fetchAll();
    }

    public function getByCpf(string $cpf): array|false
    {
        $stmt = $this->model->read()
            ->where('cpf = :cpf')
            ->setParams([
                'cpf' => $cpf
            ])
            ->execute();

        return $stmt->fetch() ?? [];
    }

    public function getById(int $id): array
    {
        $stmt = $this->model->read()
            ->where('id = :id')
            ->setParams([
                'id' => $id
            ])
            ->execute();

        return $stmt->fetch() ?? [];
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
