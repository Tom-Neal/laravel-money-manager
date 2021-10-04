<?php

namespace App\Http\Controllers;

use App\Exports\{InvoiceExport, ExpenseExport};
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function invoice()
    {
        return Excel::download(new InvoiceExport(),  'invoices.xlsx');
    }

    public function expense()
    {
        return Excel::download(new ExpenseExport(),  'expenses.xlsx');
    }

}