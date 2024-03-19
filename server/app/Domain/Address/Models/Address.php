<?php

namespace Domain\Address\Models;

use App\Core\Model;

class Address extends Model
{
    public function __construct()
    {
        parent::__construct('addresses', ['id']);
    }
}
