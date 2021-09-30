<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Services\InvoiceTaxYearService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;
    public string $text;

    public function __construct($invoice, $text)
    {
        $this->invoice = $invoice;
        $this->text = $text;
    }

    public function build(InvoiceTaxYearService $invoiceTaxYearService)
    {
        $invoicePDF = $invoiceTaxYearService->makePdfFile($this->invoice);
        $invoicePDF->save($this->invoice->file_pdf_name);
        return $this
            ->subject(config('app.name') . ' ' . $this->invoice->client->clientType->name . ': Invoice ' . $this->invoice->number_formatted)
            ->markdown('mails.invoice')
            ->attach($this->invoice->file_pdf_name);
    }

}
