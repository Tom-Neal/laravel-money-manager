<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ExpenseController extends Controller
{

    public function index()
    {
        return view('expenses.index');
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit')
            ->with(compact('expense'));
    }

    public function update(Expense $expense)
    {
        $expense->update(request([
            'description', 'price', 'price_with_vat', 'vat_included', 'date_incurred'
        ]));
        return back()->with('message', 'Expense Updated');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect('expenses')->with('message', 'Expense Deleted');
    }

}
