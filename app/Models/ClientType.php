<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ClientType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read int|null $clients_count
 * @method static \Database\Factories\ClientTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientType whereSlug($value)
 * @mixin \Eloquent
 */
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
