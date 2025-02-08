<?php

namespace App\Actions\Values;

use App\Models\Value;

class GetLast
{
    public static function execute()
    {
        return Value::getLast();
    }
}
