<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceCopyController extends Controller
{

    public function create(Invoice $invoice)
    {
        return view('invoices.copy.create')
            ->with(compact('invoice'));
    }

    public function store(Invoice $invoice)
    {

        $newInvoice = $invoice->replicate();
        $newInvoice->save();

        $newInvoice->invoiceItems()->createMany(
            $invoice->invoiceItems()
                ->select('description', 'price', 'hours', 'renewal_required')->get()->toArray()
        );
        $newInvoice->invoicePayments()->createMany(
            $invoice->invoicePayments()
                ->select('total', 'date_paid')->get()->toArray()
        );

        return redirect()->route('invoice.edit', $newInvoice)
            ->with('message', 'Invoice Copied - Update Below');
    }

}
