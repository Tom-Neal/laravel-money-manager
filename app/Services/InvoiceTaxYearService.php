<?php

namespace App\Services;

use App\Models\{Invoice, Setting};

class InvoiceTaxYearService
{

    public const FONT = 'Helvetica';

    public function makePdfFile(Invoice $invoice, bool $withPayments=false)
    {
        $settings = Setting::first();
        // Load in required models
        view()->share('invoice', $invoice,);
        view()->share('settings', $settings);
        view()->share('withPayments', $withPayments);
        // Generate the PDF
        return \PDF::loadView('downloads.invoice_pdf', [$invoice, $settings])
            ->setOptions(['defaultFont' => InvoiceTaxYearService::FONT]);
    }

}
