<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Services\{InvoiceTaxYearService, ExpenseTaxYearService};
use App\Models\{ClientType, Invoice, InvoiceItem};

class HomeController extends Controller
{

    public function __invoke(
        InvoiceTaxYearService $invoiceTaxYearService,
        ExpenseTaxYearService $expenseTaxYearService
    )
    {
        if (auth()->user()) {
            $clientTypes = ClientType::all();
            $invoiceYears = $invoiceTaxYearService->groupTogether();
            $expenseYears = $expenseTaxYearService->groupTogether();
            $invoiceItemsRenewalRequired = InvoiceItem::renewalRequiredSoon()->with('invoice')->get();
            $recentInvoices = Invoice::where('updated_at', '>', Carbon::now()->subMonth())->with('client', 'invoiceStatus')->take(4)->get();
            return view('home')
                ->with(compact(
                    'clientTypes', 'invoiceYears', 'expenseYears', 'invoiceItemsRenewalRequired', 'recentInvoices'
                ));
        }
        return redirect('login');
    }

}
