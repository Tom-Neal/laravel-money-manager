<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'clients';
    protected $with = ['address', 'businesses', 'projects', 'clientType'];
    protected $withCount = ['invoices'];

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class)
            ->latest('date_sent');
    }

    public function firstInvoice(): HasOne
    {
        return $this->hasOne(Invoice::class)
            ->oldestOfMany();
    }

    public function lastInvoice(): HasOne
    {
        return $this->hasOne(Invoice::class)
            ->latestOfMany('date_sent')
            ->withDefault();
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
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

    public function newInvoiceNumber(): string
    {
        /*
         * Creates a unique invoice number based on the client id
         */
        return
            str_pad(
                $this->id,
                3,
                '0',
                STR_PAD_LEFT
            )
            .
            str_pad(
                (int)substr($this->lastInvoice->number, 3)+1,
                3,
                '0',
                STR_PAD_LEFT
            );
    }

}
