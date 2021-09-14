<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphOne, MorphMany};

class Business extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'businesses';

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addresstable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commenttable')
            ->latest();
    }

}
