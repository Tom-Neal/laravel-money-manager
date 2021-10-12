<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};

class User extends Authenticatable implements HasMedia
{
    use Notifiable, TwoFactorAuthenticatable, HasFactory, InteractsWithMedia;

    protected $table = 'users';
    protected $hidden = [
        'password', 'remember_token',
    ];

}
