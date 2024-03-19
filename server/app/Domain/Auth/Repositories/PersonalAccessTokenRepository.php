<?php

namespace Domain\Auth\Repositories;

use Domain\Auth\Models\PersonalAccessToken;
use PDOStatement;

class PersonalAccessTokenRepository
{
    public function __construct(protected PersonalAccessToken $model)
    {
    }

    public function create(array $data): PDOStatement
    {
        return $this->model->create($data);
    }

    public function findOneByToken(string $token): array|false
    {
        $stmt = $this->model->read()
            ->where('token = :token')
            ->setParams([
                'token' => $token
            ])
            ->execute();

        return $stmt->fetch();
    }

    public function delete(string $token): PDOStatement|false
    {
        return $this->model->where('token = :token')
            ->delete()
            ->setParams([
                'token' => $token
            ])
            ->execute();
    }
}
