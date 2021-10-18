<?php

namespace App\Models;

use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePayment extends Model
{
    use HasFactory, AmountFormatter;

    protected $table = 'invoice_payments';
    protected $touches = ['invoice'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
