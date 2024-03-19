<?php

namespace Domain\Auth\Models;

use App\Core\Model;

class PersonalAccessToken extends Model
{
    public function __construct()
    {
        parent::__construct('personal_access_token', ['id', 'created_at']);
    }
}
