<?php

namespace App\Http\Livewire;

use App\Helpers\DateHelper;
use App\Models\Expense;
use Livewire\Component;

class ExpensePage extends Component
{

    public ?string $description = NULL;
    public ?int $price = NULL;
    public ?string $date_incurred = NULL;
    public bool $vat_included = true;
    public string $currentTaxYear = '';
    public string $currentTaxYearTotal = '';

    public function rules(): array
    {
        return [
            'description'    => 'required|string',
            'price'          => 'nullable|integer',
            'price_with_vat' => 'nullable|integer',
            'date_incurred'  => 'nullable|string',
            'vat_included'   => 'nullable',
        ];
    }

    public function render()
    {
        $expenses = Expense::latest('date_incurred')->paginate(20);
        $this->currentTaxYear = $this->getCurrentTaxYear($expenses);
        $this->currentTaxYearTotal = $this->getCurrentTaxYearTotal();
        return view('livewire.expense-page')
            ->with(compact('expenses'));
    }

    public function store()
    {
        Expense::create([
            'description'    => $this->description,
            'price'          => $this->vat_included ? ($this->price / 6) * 5 : $this->price,
            'price_with_vat' => $this->vat_included ? $this->price : $this->price * 1.2,
            'date_incurred'  => $this->date_incurred,
            'vat_included'   => $this->vat_included
        ]);
        $this->description = $this->price = $this->date_incurred = NULL;
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Expense Added']
        );
    }

    public function getCurrentTaxYearTotal(): string
    {
        $currentTaxYear = DateHelper::getCurrentTaxYear();
        return '£' . round(Expense::whereBetween('date_incurred', ["$currentTaxYear-04-06", ($currentTaxYear + 1) . '-04-06'])->sum('price') / 100, 2);
    }

    public function getCurrentTaxYear($expenses): string
    {
        if ($expenses->isNotEmpty()) {
            $mostRecentExpense = $expenses[0]->date_incurred;
            if ($mostRecentExpense > date('Y', strtotime($mostRecentExpense)) . '-m-d') {
                return ((int)date('Y', strtotime($mostRecentExpense)) - 1) . '-' . date('Y', strtotime($mostRecentExpense));
            }
            return ((int)date('Y', strtotime($mostRecentExpense)) - 2) . '-' . date('Y', strtotime($mostRecentExpense)) - 1;
        }
        return '';
    }

}
