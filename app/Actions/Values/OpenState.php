<?php

namespace App\Actions\Values;

use App\Models\Value;

class OpenState
{
    public static function execute()
    {
        return Value::getOpenState();
    }
}
