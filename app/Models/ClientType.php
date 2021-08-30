<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientType extends Model
{
    use HasFactory;

    protected $table = 'client_types';
    public $timestamps = false;

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

}
