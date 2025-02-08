<?php

namespace App\Actions\Values;

use App\Models\Value;
use Exception;

class Create
{
    public static function execute(array $data)
    {
        try {
            $user = new Value(
                null,
                $data['s_ts'],
                $data['s_pr'],
                $data['s_ng'],
                $data['s_dg'],
                $data['s_cn'],
                $data['s_op'],
                $data['s_sc'],
                $data['t_r0'],
                $data['t_r1'],
                $data['t_r2'],
                $data['t_r4'],
                $data['h_r0'],
                $data['h_r1'],
                $data['h_r2'],
                $data['h_r4'],
                $data['c_r1'],
                $data['c_r2'],
                $data['c_r4'],
                $data['a_r1'],
                $data['a_r2'],
                $data['a_r4'],
                $data['i_r1'],
                $data['i_r2'],
                $data['i_r4'],
                $data['e_r1'],
                $data['e_r2'],
                $data['e_r4'],
            );
            $user->save();
            return ["message" => getMessage('users_created'), "status" => true];
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
