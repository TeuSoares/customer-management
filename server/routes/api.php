<?php

use App\Core\Router;

// Permitir solicitações de qualquer origem
header("Access-Control-Allow-Origin: http://localhost:3000");

// Permitir solicitações com métodos específicos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Permitir cabeçalhos específicos
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Permitir que os cabeçalhos e cookies de autenticação sejam enviados
header("Access-Control-Allow-Credentials: true");

// Configurar o tipo de conteúdo da resposta
header("Content-Type: application/json");

$router = new Router();

$router->post('/login', 'Domain\Auth\Controllers\AuthController@login');
$router->post('/logout', 'Domain\Auth\Controllers\AuthController@logout');
$router->post('/register', 'Domain\Auth\Controllers\AuthController@register');

$router->get('/customer', 'Domain\Customer\Controllers\CustomerController@index');
$router->post('/customer', 'Domain\Customer\Controllers\CustomerController@store');
$router->put('/customer/{id}', 'Domain\Customer\Controllers\CustomerController@update');
$router->delete('/customer/{id}', 'Domain\Customer\Controllers\CustomerController@destroy');

$router->get('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@index');
$router->post('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@store');
$router->put('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@update');
$router->delete('/customer/address/{id}', 'Domain\Address\Controllers\AddressController@destroy');

$router->dispatch();
