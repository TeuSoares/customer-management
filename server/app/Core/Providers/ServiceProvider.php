<?php

namespace App\Core\Providers;

use App\Core\Providers\Interfaces\ServiceProviderInterface;

abstract class ServiceProvider implements ServiceProviderInterface
{
    public function bind(string $interface, string $implementation): void
    {
        Container::bind($interface, $implementation);
    }

    abstract public function register(): void;
}
