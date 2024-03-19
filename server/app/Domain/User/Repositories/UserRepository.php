<?php

namespace Domain\User\Repositories;

use Domain\User\Models\User;
use PDOStatement;

class UserRepository
{
    public function __construct(protected User $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function findOneByEmail(string $email): array|false
    {
        $stmt = $this->model->read()
            ->where('email = :email')
            ->setParams([
                'email' => $email
            ])
            ->execute();

        return $stmt->fetch();
    }
}
