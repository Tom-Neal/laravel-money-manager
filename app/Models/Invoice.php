<?php

namespace App\Models;

use App\Mail\InvoiceClientMail;
use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne, HasOneThrough, MorphMany};
use Illuminate\Support\Facades\Mail;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string $number
 * @property int|null $total
 * @property string|null $date_sent
 * @property string|null $date_paid
 * @property string|null $email_sent
 * @property int $invoice_status_id
 * @property int|null $business_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\InvoiceItem|null $firstItem
 * @property-read string $file_pdf_name
 * @property-read string $number_formatted
 * @property-read string $price_formatted
 * @property-read string $price_with_vat_formatted
 * @property-read string $total_formatted
 * @property-read \App\Models\InvoiceStatus $invoiceStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\InvoicePayment|null $lastPayment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoicePayment[] $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\InvoiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDatePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory, AmountFormatter;

    protected $table = 'invoices';
    protected $with = ['firstItem', 'lastPayment'];
    protected $appends = ['number_formatted'];

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
        return "#" . $this->number;
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
