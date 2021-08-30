<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function index()
    {
        $year = DateHelper::getCurrentTaxYear();
        $invoices = Invoice::query()
            ->with('client', 'invoiceStatus', 'invoiceItems')
            ->latest('date_sent')
            ->paginate(20);
        return view('invoices.index')->with(compact('year', 'invoices'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit')->with(compact('invoice'));
    }

}
