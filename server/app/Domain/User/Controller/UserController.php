<?php

namespace Domain\User\Controller;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use Domain\User\Models\User;

class UserController extends Controller
{
    public function index($request)
    {
        echo 'Rota index ';
    }

    public function show($request)
    {
        echo 'Rota show ' . $request['id'];
    }

    public function store(): Response
    {
        $model = new User;

        $teste = 'teste';

        $stmt = $model->read()
            ->where("users.id = :id")
            ->groupBy('name')
            ->orderBy(['name', 'email'], 'ASC')
            ->limit('5')
            ->setParams([
                'id' => $teste,
            ])
            ->execute();

        // $stmt = $model
        //     ->where("email = :email")
        //     ->delete(['name' => 'Mateus'])
        //     ->setParams([
        //         'email' => $teste
        //     ])
        //     ->execute();

        dd($stmt);

        $response = response()->withHeader('Accept', 'application/json')
            ->withHeader('Cache-Control', 'application/json');

        return $this->responseMessage($response, ['teste' => 'Esse é um teste de response'], 201);
    }

    public function update($request)
    {
        echo 'Rota update ' . $request['id'];
    }

    public function destroy($request)
    {
        echo 'Rota delete ' . $request['id'];
    }
}
