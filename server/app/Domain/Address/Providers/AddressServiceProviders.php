<?php

namespace Domain\Address\Providers;

use App\Core\Providers\ServiceProvider;
use Domain\Address\Repositories\AddressRepository;
use Domain\Address\Repositories\AddressRepositoryInterface;

class AddressServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        $this->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }
}
