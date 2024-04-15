<?php

namespace Domain\Customer\Repositories;

use Domain\Customer\Models\Customer;
use PDOStatement;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(protected Customer $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function getAllByUser(int $user_id, array $params = []): array
    {
        $stmt = $this->model->read('customers.*')
            ->join('users', 'users.id', 'customers.user_id')
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

        return $stmt->fetch();
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->model->read('customers.*')
            ->join('users', 'users.id', 'customers.user_id')
            ->where('customers.id = :id')
            ->where('user_id = :user_id')
            ->setParams([
                'id' => $id,
                'user_id' => user()->id
            ])
            ->execute();

        return $stmt->fetch();
    }

    public function update(int $id, array $data): int
    {
        return $this->model->where('id = :id')
            ->where('user_id = :user_id')
            ->update($data)
            ->setParams([
                'id' => $id,
                'user_id' => user()->id,
                ...$data
            ])
            ->execute()
            ->rowCount();
    }

    public function delete(int $id): int
    {
        return $this->model->where('id = :id')
            ->where('user_id = :user_id')
            ->delete()
            ->setParams([
                'id' => $id,
                'user_id' => user()->id,
            ])
            ->execute()
            ->rowCount();
    }
}
