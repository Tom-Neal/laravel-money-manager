<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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

            // Caching this data for a short period of time
            $cacheSeconds = 60;

            $invoiceYears = Cache::remember('invoiceYearsCache', $cacheSeconds, function () use($invoiceTaxYearService) {
                return $invoiceTaxYearService->groupTogether();
            });

            $expenseYears = Cache::remember('expenseYearsCache', $cacheSeconds, function () use($expenseTaxYearService) {
                return $expenseTaxYearService->groupTogether();
            });

            $invoiceItemsRenewalRequired = Cache::remember('renewalRequiredSoonCache', $cacheSeconds, function () {
                return InvoiceItem::query()
                    ->renewalRequiredSoon()
                    ->with('invoice')
                    ->get();
            });

            $recentInvoices = Cache::remember('recentInvoicesCache', $cacheSeconds, function () {
                return Invoice::query()
                    ->where('updated_at', '>', Carbon::now()->subMonth())
                    ->with('client', 'invoiceStatus')
                    ->latest('updated_at')
                    ->take(4)
                    ->get();
            });

            return view('home')
                ->with(compact(
                    'invoiceYears', 'expenseYears', 'invoiceItemsRenewalRequired', 'recentInvoices'
                ));

        }
        return redirect('login');
    }

}
