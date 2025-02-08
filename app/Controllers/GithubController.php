<?php

namespace App\Controllers;

use GeekGroveOfficial\PhpSmartValidator\Validator\Validator;
use App\Actions\Github\Create;
use App\Actions\Github\GetLast;
use App\Traits\ApiResponse;
use Exception;
use Flight;

class GithubController
{
    use ApiResponse;

    public function documentation()
    {
        Flight::set('flight.views.path', './../docs');
        Flight::render('index', [ ]);
    }

    public function last()
    {
        return $this->success(GetLast::execute(), getMessage('values_route'), 200);
    }

    public function store()
    {
        $request = Flight::request()->data->getData();

        $validator = new Validator($request, [
            's_ts' => ['required', 'string'],
            //'s_pr' => ['required', 'integer'],
            //'s_ng' => ['required', 'integer'],
            //'s_dg' => ['required'],
            's_cn' => ['required', 'integer'],
            's_op' => ['required', 'integer'],
            's_sc' => ['required', 'string'],
        ]);

        if (!$validator->validate())
            return $this->failed($validator->errors(), getMessage('invalid_input'), 400);

        try {
            $result = Create::execute($request);
            return $this->success([], $result['message'], 201);
        } catch (Exception $exception) {
            return $this->failed([], getMessage('values_not_created'));
        }
    }

}
