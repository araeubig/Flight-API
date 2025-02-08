<?php

namespace App\Controllers;

use GeekGroveOfficial\PhpSmartValidator\Validator\Validator;
use App\Actions\Values\Create;
use App\Actions\Values\GetLast;
use App\Actions\Values\OpenState;
use App\Traits\ApiResponse;
use Exception;
use Flight;

class ValueController
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

    public function open()
    {
        return $this->success(OpenState::execute(), getMessage('openstate_route'), 200);
    }

    public function store()
    {
        $request = Flight::request()->data->getData();

        $validator = new Validator($request, [
            's_ts' => ['required','string'],
            's_pr' => ['bool'],
            's_ng' => ['bool'],
            's_dg' => ['bool'],
            's_cn' => ['integer'],
            's_op' => ['integer'],
            's_sc' => ['string'],
            't_r0' => ['numeric'],
            't_r1' => ['numeric'],
            't_r2' => ['numeric'],
            't_r4' => ['numeric'],
            'h_r0' => ['numeric'],
            'h_r1' => ['numeric'],
            'h_r2' => ['numeric'],
            'h_r4' => ['numeric'],
            'c_r1' => ['numeric'],
            'c_r2' => ['numeric'],
            'c_r4' => ['numeric'],
            'a_r1' => ['numeric'],
            'a_r2' => ['numeric'],
            'a_r4' => ['numeric'],
            'i_r1' => ['numeric'],
            'i_r2' => ['numeric'],
            'i_r4' => ['numeric'],
            'e_r1' => ['bool'],
            'e_r2' => ['bool'],
            'e_r4' => ['bool'],
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
