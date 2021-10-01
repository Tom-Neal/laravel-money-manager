<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    protected $appends = ['price_formatted', 'price_with_vat_formatted'];

    public function getPriceFormattedAttribute(): string
    {
        return "£" . substr(round($this->price), 0, -2) . "." . substr(round($this->price), -2);
    }

    public function getPriceWithVatFormattedAttribute(): string
    {
        return "£" . substr(round($this->price_with_vat), 0, -2) . "." . substr(round($this->price_with_vat), -2);
    }

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
