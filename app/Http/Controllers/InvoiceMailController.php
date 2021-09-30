<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceMailController extends Controller
{

    public function create(Invoice $invoice)
    {
        return view('invoices.mails.create')->with(compact('invoice'));
    }

    public function store(Invoice $invoice)
    {
        $invoice->sendEmailToClient(request()['text']);
        return back()->with('message', 'Invoice Email Has Been Sent To Client');
    }

}
