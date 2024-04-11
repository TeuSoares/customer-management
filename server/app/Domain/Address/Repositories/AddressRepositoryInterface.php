<?php

namespace Domain\Address\Repositories;

use PDOStatement;

interface AddressRepositoryInterface
{
    public function create(array $data): PDOStatement;

    public function getAllByCustomer(int $customer_id): array;

    public function delete(int $id): int;
}
