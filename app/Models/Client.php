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

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property int $client_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Business[] $businesses
 * @property-read int|null $businesses_count
 * @property-read \App\Models\ClientType $clientType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Invoice|null $firstInvoice
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\Invoice $lastInvoice
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Database\Factories\ClientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereClientTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Client extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'clients';
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
