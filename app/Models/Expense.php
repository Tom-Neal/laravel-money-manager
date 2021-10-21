<?php

namespace App\Models;

use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property string $description
 * @property string|null $price
 * @property string|null $price_with_vat
 * @property int $vat_included
 * @property string|null $date_incurred
 * @property string $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $price_formatted
 * @property-read string $price_with_vat_formatted
 * @property-read string $total_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDateIncurred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense wherePriceWithVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereVatIncluded($value)
 * @mixin \Eloquent
 */
class Expense extends Model
{
    use HasFactory, AmountFormatter;

    protected $table = 'expenses';

    public const CATEGORY_CHARGE = 'charge';
    public const CATEGORY_TRAVEL = 'travel';

    public function getPriceWithVAT(): int
    {
        if ($this->vat_included) {
            return $this->price;
        }
        return $this->price * 1.2;
    }

    public function getPriceWithoutVAT(): int
    {
        if ($this->vat_included) {
            return $this->price / 6 * 5;
        }
        return $this->price;
    }

}
