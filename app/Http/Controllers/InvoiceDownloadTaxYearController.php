<?php

namespace App\Http\Controllers;

use App\Services\InvoiceTaxYearService;

class InvoiceDownloadTaxYearController extends Controller
{

    public function __invoke(string $year, InvoiceTaxYearService $invoiceTaxYearService)
    {

        $zipFileName = $invoiceTaxYearService->makeZipFile($year);

        return response()
            ->download($zipFileName)
            ->deleteFileAfterSend(true);
    }

}
