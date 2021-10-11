<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends Model
{

    protected $table = 'settings';

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addresstable');
    }

    public const PREFERENCES = 1;

}
