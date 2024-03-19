<?php

namespace Domain\Customer\Models;

use App\Core\Model;

class Customer extends Model
{
    public function __construct()
    {
        parent::__construct('customers', ['id']);
    }
}
