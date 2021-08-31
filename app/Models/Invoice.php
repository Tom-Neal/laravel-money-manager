<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne, HasOneThrough};

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $with = ['firstInvoiceItem', 'lastPayment'];
    protected $appends = ['total_formatted', 'number_formatted'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function firstInvoiceItem(): HasOne
    {
        return $this->hasOne(InvoiceItem::class)
            ->oldestOfMany();
    }

    public function invoicePayments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function lastPayment(): HasOne
    {
        return $this->hasOne(InvoicePayment::class)
            ->latestOfMany();
    }

    public function project(): HasOneThrough
    {
        return $this->hasOneThrough(InvoiceProject::class, 'invoice_project');
    }

    public function scopePaid($query)
    {
        return $query->where('invoice_status_id', InvoiceStatus::PAID);
    }

    public function getNumberFormattedAttribute(): string
    {
        return "#" . round((int)$this->number);
    }

    public function getTotalFormattedAttribute(): string
    {
        return "£" . substr(round($this->total), 0, -2) . "." . substr(round($this->total), -2);
    }

    public function isPaid(): bool
    {
        return (int)$this->invoice_status_id === InvoiceStatus::PAID;
    }

    public function invoicePaymentTotalCheck(): bool
    {
        // Ensure the total equates to sum of all invoice payments
        if (
            $this->total > $this->invoicePayments->sum('total') &&
            $this->invoicePayments->isNotEmpty()
        ) {
            return false;
        }
        return true;
    }

    public function downloadCheck(): bool
    {
        // Only permit invoice download/export if these conditions are met
        if (!$this->date_sent || !$this->total || $this->invoiceItems->isEmpty()) {
            return false;
        }
        return true;
    }

}
