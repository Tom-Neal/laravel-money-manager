<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceStatus
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $colour
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceStatus whereName($value)
 * @mixin \Eloquent
 */
class InvoiceStatus extends Model
{

    protected $table = 'invoice_statuses';
    public $timestamps = false;

    public const CREATED = 1;
    public const SENT = 2;
    public const PART_PAID = 3;
    public const PAID = 4;

}
