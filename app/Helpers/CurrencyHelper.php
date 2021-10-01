<?php

namespace App\Helpers;

class CurrencyHelper
{

    public static function getFormattedValue(int $value): string
    {
        return
            "£".
            substr(
                str_pad($value, 3, 0, STR_PAD_LEFT), 0, -2).
                "."
                .substr(str_pad($value, 2, 00, STR_PAD_LEFT), -2
            );
    }

}
