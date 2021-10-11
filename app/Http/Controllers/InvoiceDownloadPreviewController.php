<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoiceTaxYearService;

class InvoiceDownloadPreviewController extends Controller
{

    public function __invoke(Invoice $invoice, InvoiceTaxYearService $invoiceTaxYearService)
    {
        $invoiceTaxYearService->makePdfFile($invoice);
        return view('downloads.invoice_pdf');
    }

}
