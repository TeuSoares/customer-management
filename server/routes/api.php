<?php

use App\Core\Router;

$router = new Router();

$router->post('/login', 'Domain\Auth\Controllers\AuthController@login');
$router->post('/logout', 'Domain\Auth\Controllers\AuthController@logout');
$router->post('/register', 'Domain\Auth\Controllers\AuthController@register');

$router->get('/customer', 'Domain\Customer\Controllers\CustomerController@index');
$router->post('/customer', 'Domain\Customer\Controllers\CustomerController@store');
$router->get('/customer/{id}', 'Domain\Customer\Controllers\CustomerController@show');
$router->put('/customer/{id}', 'Domain\Customer\Controllers\CustomerController@update');
$router->delete('/customer/{id}', 'Domain\Customer\Controllers\CustomerController@destroy');

$router->get('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@index');
$router->post('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@store');
$router->put('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@update');
$router->delete('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@destroy');

$router->dispatch();
