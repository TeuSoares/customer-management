<?php

namespace Domain\Customer\Providers;

use App\Core\Providers\ServiceProvider;
use Domain\Customer\Repositories\CustomerRepository;
use Domain\Customer\Repositories\CustomerRepositoryInterface;

class CustomerServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    }
}
