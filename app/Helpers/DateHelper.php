<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{

    /*
     * If current date is after start of new tax year, return
     * that year, else return year before
     * (returns first part of year e.g. 2021 in 2021-2022)
     */
    public static function getCurrentTaxYear(): string
    {
        return
            Carbon::now()->format('Y') . '-04-06' < Carbon::now() ?
                (int)Carbon::now()->format('Y') :
                (int)Carbon::now()->subYear()->format('Y');
    }

}
