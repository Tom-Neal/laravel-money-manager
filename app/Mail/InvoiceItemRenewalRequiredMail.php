<?php

namespace App\Mail;

use App\Models\InvoiceItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceItemRenewalRequiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public InvoiceItem $invoiceItem;

    public function __construct($invoiceItem)
    {
        $this->invoiceItem = $invoiceItem;
    }

    public function build()
    {
        return $this
            ->subject(config('app.name') . ' Invoice Item Renewal Required')
            ->markdown('mails.invoice_item_renewal_required');
    }

}
