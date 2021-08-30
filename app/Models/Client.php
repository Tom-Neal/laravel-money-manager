<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'clients';
    protected $with = ['clientType'];

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class);
    }

}
