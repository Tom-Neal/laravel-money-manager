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
    public string $category = '';
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
            'category'       => 'required|string',
            'vat_included'   => 'nullable',
        ];
    }

    public function render()
    {
        $expenses = Expense::query()->latest('date_incurred')->take(1)->get();
        $this->currentTaxYear = $this->getCurrentTaxYear($expenses);
        $this->currentTaxYearTotal = $this->getCurrentTaxYearTotal();
        return view('livewire.expense-page')
            ->with(compact('expenses'));
    }

    public function mount()
    {
        $this->category = Expense::CATEGORY_CHARGE;
    }

    public function store()
    {
        Expense::create([
            'description'    => $this->description,
            'price'          => $this->vat_included ? round(($this->price / 6) * 5) : $this->price,
            'price_with_vat' => $this->vat_included ? $this->price : round($this->price * 1.2),
            'date_incurred'  => $this->date_incurred,
            'category'       => $this->category,
            'vat_included'   => $this->vat_included
        ]);
        $this->reset(['description', 'price', 'date_incurred', 'category']);
        $this->emit('store');
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Expense Added']
        );
    }

    public function getCurrentTaxYearTotal(): string
    {
        $currentTaxYear = DateHelper::getCurrentTaxYear();
        return
            '£' . round(Expense::whereBetween('date_incurred', ["$currentTaxYear-04-06", ($currentTaxYear + 1) . '-04-06'])->sum('price') / 100, 2);
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
