<?php

namespace App\Console\Commands;

use App\Models\InvoiceItem;
use Illuminate\Console\Command;

class InvoiceItemRenewalRequiredCheck extends Command
{

    protected $signature = 'command:invoice_item_renewal_required_check';
    protected $description = 'Check for any upcoming invoice items renewals required.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        InvoiceItem::renewalRequiredSoon()->where('renewal_required_email_sent', NULL)->each(function ($invoiceItem)
        {
            $invoiceItem->sendEmailAsRenewalRequired();
        });
    }

}
