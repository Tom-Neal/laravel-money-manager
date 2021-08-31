<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoiceTaxYearService;

class InvoiceDownloadController extends Controller
{

    public function __invoke(Invoice $invoice, InvoiceTaxYearService $invoiceTaxYearService)
    {

        $pdfFile = $invoiceTaxYearService->makePdfFile($invoice);

        return $pdfFile
            ->download($invoice->file_pdf_name);
    }

}
