<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Services\{InvoiceTaxYearService, ExpenseTaxYearService};
use App\Models\{Invoice, InvoiceItem};

class HomeController extends Controller
{

    public function __invoke(
        InvoiceTaxYearService $invoiceTaxYearService,
        ExpenseTaxYearService $expenseTaxYearService
    )
    {
        if (auth()->user()) {

            $invoiceYears = $invoiceTaxYearService->groupTogether();

            $expenseYears = $expenseTaxYearService->groupTogether();

            $invoiceItemsRenewalRequired = InvoiceItem::query()->renewalRequiredSoon()->with('invoice')->get();

            $recentInvoices = Invoice::query()
                ->where('updated_at', '>', Carbon::now()->subMonth())
                ->with('client', 'invoiceStatus')
                ->take(4)
                ->get();

            return view('home')
                ->with(compact(
                    'invoiceYears', 'expenseYears', 'invoiceItemsRenewalRequired', 'recentInvoices'
                ));

        }
        return redirect('login');
    }

}
