<?php

namespace App\Models;

use App\Mail\InvoiceItemRenewalRequiredMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';

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

    public function getPriceFormattedAttribute(): string
    {
        return "£" . substr($this->price, 0, -2) . "." . substr($this->price, -2);
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
