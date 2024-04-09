<?php

use App\Core\Http\Routes\Router;

$router = Router::singleInstance();

$router->post('/login', 'Domain\Auth\Controllers\AuthController@login');
$router->post('/logout', 'Domain\Auth\Controllers\AuthController@logout')->middleware(['auth']);
$router->post('/register', 'Domain\Auth\Controllers\AuthController@register');

$router->group('/customer', function () {
    $this->addGroupMiddleware(['auth']);

    $this->get('', 'Domain\Customer\Controllers\CustomerController@index');
    $this->post('', 'Domain\Customer\Controllers\CustomerController@store');
    $this->get('/{id}', 'Domain\Customer\Controllers\CustomerController@show');
    $this->put('/{id}', 'Domain\Customer\Controllers\CustomerController@update');
    $this->delete('/{id}', 'Domain\Customer\Controllers\CustomerController@destroy');
});

$router->group('/customer/address', function () {
    $this->addGroupMiddleware(['auth']);

    $this->get('/{id}', 'Domain\Address\Controllers\AddressController@index');
    $this->post('/{id}', 'Domain\Address\Controllers\AddressController@store');
    $this->put('/{id}', 'Domain\Address\Controllers\AddressController@update');
    $this->delete('/{id}', 'Domain\Address\Controllers\AddressController@destroy');
});

$router->dispatch();
