<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoiceTaxYearService;

class InvoiceWithPaymentsDownloadController extends Controller
{

    public function __invoke(Invoice $invoice, InvoiceTaxYearService $invoiceTaxYearService)
    {

        $pdfFile = $invoiceTaxYearService->makePdfFile($invoice, true);

        return $pdfFile
            ->download($invoice->file_pdf_name);
    }

}
