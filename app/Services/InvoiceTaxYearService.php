<?php

namespace App\Services;

use App\Models\{Invoice, Setting};
use App\Helpers\DateHelper;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Illuminate\Support\Facades\Storage;

class InvoiceTaxYearService
{

    public const FONT = 'Helvetica';

    public function groupTogether(?int $year = NULL, int $yearCount = 5, bool $paid = true): array
    {
        // If year is provided, return invoices for that year,
        // otherwise, return most recent year
        $year = $year ?? DateHelper::getCurrentTaxYear();
        $invoiceYears = array();
        for ($i = 0; $i < $yearCount; $i++) {
            $invoices = Invoice::query()->whereBetween('date_paid', ["$year-04-06", ($year + 1) . "-04-06"]);
            // Scope to paid if needed (date_paid may be set but has been refunded?)
            if ($paid) $invoices = $invoices->paid();
            $invoiceYears["$year-" . ($year + 1)] = $invoices->with('client', 'invoiceItems')->get();
            $year--;
        }
        return $invoiceYears;

    }

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

    public function makeZipFile(int $year, bool $withPayments=false): string
    {

        $zipFileName = 'invoices-' . $year . '.zip';
        $zip = new Filesystem(new ZipArchiveAdapter($zipFileName));

        $invoicesYear = $this->groupTogether($year, 1);

        foreach ($invoicesYear as $invoices) {
            // Include default txt file to prevent zip file creation failure for now
            $zip->put("$year.txt", count($invoices) . ' invoices');
            // Loop through invoices and create a PDF for each
            foreach ($invoices as $invoice) {
                // Make the file
                $pdfFile = $this->makePdfFile($invoice, $withPayments);
                // Put the file in storage
                Storage::put("invoices/$invoice->file_pdf_name", $pdfFile->output());
                // Retrieve the file
                $pdfFile = Storage::disk()->get("invoices/$invoice->file_pdf_name");
                // Add file to zip
                $zip->put("invoices-$year/$invoice->file_pdf_name", $pdfFile);
                // Remove the files from storage to keep things tidy
                Storage::delete("invoices/$invoice->file_pdf_name");
            }
        }

        $zip->getAdapter()->getArchive()->close();

        return $zipFileName;

    }

}
