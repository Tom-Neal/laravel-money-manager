<?php

namespace App\Services;

use App\Models\{Invoice, Setting};
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\Storage;

class InvoiceTaxYearService
{

    public const FONT = 'Helvetica';

    public function groupTogether(?int $year = NULL, int $yearCount = 5, bool $withRelations=false,  bool $paid = true): array
    {
        // If year is provided, return invoices for that year,
        // otherwise, return most recent year

        $year = $year ?? DateHelper::getCurrentTaxYear();

        $invoiceYears = array();

        for ($i = 0; $i < $yearCount; $i++) {
            $invoices = Invoice::query()->whereBetween('date_paid', ["{$year}-04-06", ($year + 1) . "-04-06"]);
            // Scope to paid if needed (date_paid may be set but has been refunded?)
            if ($paid) $invoices = $invoices->paid();
            // Include relations?
            if($withRelations) $invoiceYears["{$year}-" . ($year + 1)] = $invoices->with('client.clientType', 'client.address', 'items', 'payments');
            $invoiceYears["{$year}-" . ($year + 1)] = $invoices->get();
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

        $zipFileName = "invoices-{$year}.zip";

        $invoicesYear = $this->groupTogether($year, 1, true);

        $zip = new \ZipArchive();
        $zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($invoicesYear as $invoices) {
            // Include default txt file to prevent zip file creation failure for now
            Storage::put("invoices/{$year}.txt", count($invoices) . ' invoices');
            $zip->addFile(storage_path("app/invoices/{$year}.txt"), 'invoices.txt');
            // Loop through invoices and create a PDF for each
            foreach ($invoices as $invoice) {
                // Make the file
                $pdfFile = $this->makePdfFile($invoice, $withPayments);
                // Put the file in storage
                Storage::put("invoices/{$invoice->file_pdf_name}", $pdfFile->output());
                // Retrieve the file
                $zip->addFile(
                    storage_path("app/invoices/{$invoice->file_pdf_name}"),
                    "invoices/{$invoice->file_pdf_name}"
                );
            }
        }

        $zip->close();

        foreach ($invoicesYear as $invoices) {
            foreach ($invoices as $invoice) {
                // Remove the files from storage to keep things tidy
                Storage::delete("invoices/{$invoice->file_pdf_name}");
            }
        }

        return $zipFileName;

    }

}
