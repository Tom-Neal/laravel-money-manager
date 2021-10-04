<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'invoice_payments';
    protected $touches = ['invoice'];

    public function getTotalFormattedAttribute(): string
    {
        return "£" . substr(round($this->total), 0, -2) . "." . substr(round($this->total), -2);
    }

}
