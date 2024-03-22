<?php

namespace Domain\Customer\Repositories;

use PDOStatement;

interface CustomerRepositoryInterface
{
    public function create(array $data): PDOStatement;

    public function getAllByUser(int $user_id, array $params = []): array;

    public function getByCpf(string $cpf): array|false;

    public function getById(int $id): array;

    public function update(int $id, array $data): int;

    public function delete(int $id): int;
}
