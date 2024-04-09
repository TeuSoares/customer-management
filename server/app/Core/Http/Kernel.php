<?php

namespace App\Core\Http;

use App\Core\Http\Middlewares\CheckIfUserIsAuthenticated;

class Kernel
{
    private function middlewareAliases(): array
    {
        return [
            'auth' => CheckIfUserIsAuthenticated::class
        ];
    }

    public function getMiddleware(): array
    {
        return $this->middlewareAliases();
    }
}
