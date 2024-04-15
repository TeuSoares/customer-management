<?php

use App\Core\Providers\Container;

Container::registerServiceProviders(config('providers'));

set_exception_handler([App\Core\Exceptions\Handler::class, 'handler']);
