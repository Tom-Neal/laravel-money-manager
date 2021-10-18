<?php

namespace App\Models;

use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\InvoicePayment
 *
 * @property int $id
 * @property int $total
 * @property string|null $date_paid
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $price_formatted
 * @property-read string $price_with_vat_formatted
 * @property-read string $total_formatted
 * @property-read \App\Models\Invoice $invoice
 * @method static \Database\Factories\InvoicePaymentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereDatePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoicePayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
