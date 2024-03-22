<?php

namespace Domain\User\Providers;

use App\Core\Providers\ServiceProvider;
use Domain\User\Repositories\UserRepository;
use Domain\User\Repositories\UserRepositoryInterface;

class UserServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
