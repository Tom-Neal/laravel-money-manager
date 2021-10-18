<?php

namespace App\Models;

use App\Mail\InvoiceItemRenewalRequiredMail;
use App\Traits\AmountFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

/**
 * App\Models\InvoiceItem
 *
 * @property int $id
 * @property string $description
 * @property int $price
 * @property int|null $hours
 * @property string|null $renewal_required
 * @property string|null $renewal_required_email_sent
 * @property int $invoice_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $price_formatted
 * @property-read string $price_with_vat_formatted
 * @property-read string $total_formatted
 * @property-read \App\Models\Invoice $invoice
 * @method static \Database\Factories\InvoiceItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem renewalRequired()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem renewalRequiredSoon()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereRenewalRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereRenewalRequiredEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceItem extends Model
{
    use HasFactory, AmountFormatter;

    protected $table = 'invoice_items';
    protected $touches = ['invoice'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function scopeRenewalRequired($query)
    {
        return $query->where('renewal_required', '!=', NULL)
            ->latest('renewal_required');
    }

    public function scopeRenewalRequiredSoon($query)
    {
        return $query->where('renewal_required', '<', Carbon::now()->subWeek())
            ->where('renewal_required', '>', Carbon::now())
            ->latest('renewal_required');
    }

    public function sendEmailAsRenewalRequired()
    {
        $this->update([
            'renewal_required_email_sent' => NOW()
        ]);
        Mail::to(Setting::first()->email)
            ->send(new InvoiceItemRenewalRequiredMail($this));
    }

}
