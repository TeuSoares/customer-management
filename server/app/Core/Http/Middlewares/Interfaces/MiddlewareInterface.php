<?php

namespace App\Core\Http\Middlewares\Interfaces;

interface MiddlewareInterface
{
    public function handle(): void;
}
