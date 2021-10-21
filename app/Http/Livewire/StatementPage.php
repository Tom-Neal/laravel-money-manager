<?php

namespace App\Http\Livewire;

use App\Helpers\DateHelper;
use App\Models\{ClientType, Invoice, Expense};
use Livewire\Component;

class StatementPage extends Component
{

    public bool $showData = false;
    public string $dateStart;
    public string $dateEnd;
    public array $clientTypeInvoices;
    public int $expenseTotal;
    public int $expenseTotalWithVat;

    public function render()
    {
        return view('livewire.statement-page');
    }

    public function mount()
    {
        // Load previous tax year by default
        $year = DateHelper::getCurrentTaxYear();
        $this->dateStart = ($year - 1) . "-04-06";
        $this->dateEnd = "$year-04-05";
    }

    public function getData()
    {
        // Retrieve invoice by client type and expense data

        $clientTypes = ClientType::all(['id', 'name']);

        foreach($clientTypes as $clientType) {

            $invoiceTotal = Invoice::query()
                ->whereBetween('date_paid', [$this->dateStart, $this->dateEnd])
                ->whereHas('client', function($query) use($clientType) {
                    $query->where('client_type_id', $clientType->id);
                })->sum('total');

            $this->clientTypeInvoices["$clientType->name"] = $invoiceTotal;

        }

        $this->expenseTotal = Expense::query()
            ->whereBetween('date_incurred', [$this->dateStart, $this->dateEnd])
            ->sum('price');

        $this->expenseTotalWithVat = Expense::query()
            ->whereBetween('date_incurred', [$this->dateStart, $this->dateEnd])
            ->sum('price_with_vat');

        $this->showData = true;

        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Data Retrieved']
        );

    }

}
