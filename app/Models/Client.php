<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'clients';
    protected $with = ['clientType'];

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
            ->latestOfMany()
            ->withDefault();
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
                substr((int)$this->lastInvoice->number + 1, 3),
                3,
                '0',
                STR_PAD_LEFT
            );
    }

}
