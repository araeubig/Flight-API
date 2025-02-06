<?php

namespace App\Actions\Users;

use App\Models\State;

class GetLast
{
    public static function execute()
    {
        return State::getLast();
    }
}
