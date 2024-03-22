<?php

use App\Core\Providers\Container;

$configApp = getContentFromFile(__DIR__ . '/../config/app.php');

Container::registerServiceProviders($configApp['providers']);

set_exception_handler([App\Core\Exceptions\Handler::class, 'handler']);
