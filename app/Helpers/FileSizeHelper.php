<?php

namespace App\Helpers;

class FileSizeHelper
{

    public static function getFormattedValue(int $size, $precision = 2): string
    {
            $base = log($size, 1024);
            $suffixes = array('B', 'KB', 'MB', 'GB');
            return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

}
