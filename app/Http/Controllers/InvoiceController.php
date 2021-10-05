<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function index()
    {
        $year = DateHelper::getCurrentTaxYear();
        return view('invoices.index')->with(compact('year'));
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit')->with(compact('invoice'));
    }

}
