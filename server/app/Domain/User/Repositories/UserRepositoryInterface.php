<?php

namespace Domain\User\Repositories;

use PDOStatement;

interface UserRepositoryInterface
{
    public function create(array $data): PDOStatement;
    public function findOneByEmail(string $email): array|false;
}
