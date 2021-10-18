<?php

namespace App\Traits;

trait AmountFormatter
{

    public function getTotalFormattedAttribute(): string
    {
        return "£" . substr($this->total, 0, -2) . "." . substr($this->total, -2);
    }

    public function getPriceFormattedAttribute(): string
    {
        return "£" . substr($this->price, 0, -2) . "." . substr($this->price, -2);
    }

    public function getPriceWithVatFormattedAttribute(): string
    {
        return "£" . substr($this->price_with_vat, 0, -2) . "." . substr($this->price_with_vat, -2);
    }

}