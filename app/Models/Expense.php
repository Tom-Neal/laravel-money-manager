<?php

namespace App\Models;

use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory, AmountFormatter;

    protected $table = 'expenses';

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
