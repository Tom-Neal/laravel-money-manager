<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'invoice_payments';
    protected $touches = ['invoice'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getTotalFormattedAttribute(): string
    {
        return "£" . substr(round($this->total), 0, -2) . "." . substr(round($this->total), -2);
    }

}
