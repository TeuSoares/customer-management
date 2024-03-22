<?php

use App\Core\Providers\Container;

$configApp = getContentFromFile(__DIR__ . '/../config/app.php');

Container::registerServiceProviders($configApp['providers']);
