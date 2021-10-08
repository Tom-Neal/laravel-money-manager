<?php

namespace App\Models;

use App\Mail\InvoiceClientMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne, HasOneThrough, MorphMany};
use Illuminate\Support\Facades\Mail;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $with = ['firstItem', 'lastPayment'];
    protected $appends = ['total_formatted', 'number_formatted'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function firstItem(): HasOne
    {
        return $this->hasOne(InvoiceItem::class)
            ->oldestOfMany();
    }

    public function payments(): HasMany
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

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commenttable')
            ->latest();
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

    public function getFilePdfNameAttribute(): string
    {
        return
            str_replace(
                ' ',
                '_',
                $this->client->name . "_$this->number" . "_" . date('d_m_Y', strtotime($this->date_sent)) . ".pdf"
            );
    }

    public function isPaid(): bool
    {
        return (int)$this->invoice_status_id === InvoiceStatus::PAID;
    }

    public function sendEmailToClient(string $text)
    {
        $this->update([
            'email_sent' => NOW()
        ]);
        Mail::to($this->client->email, $this->client->name)
            ->send(new InvoiceClientMail($this, $text));
    }

    public function invoicePaymentTotalCheck(): bool
    {
        // Ensure the total equates to sum of all invoice payments
        if (
            $this->total > $this->payments->sum('total') &&
            $this->payments->isNotEmpty()
        ) {
            return false;
        }
        return true;
    }

    public function downloadCheck(): bool
    {
        // Only permit invoice download/export if these conditions are met
        if (!$this->date_sent || !$this->total || $this->items->isEmpty()) {
            return false;
        }
        return true;
    }

}
