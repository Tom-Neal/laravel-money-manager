<?php

namespace App\Http\Controllers;

use App\Services\InvoiceTaxYearService;

class InvoiceWithPaymentsDownloadTaxYearController extends Controller
{

    public function __invoke(string $year, InvoiceTaxYearService $invoiceTaxYearService)
    {

        $zipFileName = $invoiceTaxYearService->makeZipFile($year, true);

        return response()
            ->download($zipFileName)
            ->deleteFileAfterSend(true);
    }

}
