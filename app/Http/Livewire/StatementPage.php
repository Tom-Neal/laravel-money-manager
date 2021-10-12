<?php

namespace App\Http\Livewire;

use App\Models\{ClientType, Invoice, Expense};
use Livewire\Component;

class StatementPage extends Component
{

    public bool $showData = false;
    public string $dateStart = '2020-04-06';
    public string $dateEnd = '2021-04-05';
    public array $clientTypeInvoices;
    public int $expenseTotal;

    public function render()
    {
        return view('livewire.statement-page');
    }

    public function getData()
    {
        // TODO - Refactor to service class
        $clientTypes = ClientType::all();
        foreach($clientTypes as $clientType) {
            $invoiceTotal = Invoice::query()->whereBetween('date_paid', [$this->dateStart, $this->dateEnd])
                ->whereHas('client', function($query) use($clientType) {
                    $query->where('client_type_id', $clientType->id);
                })->sum('total');
            $this->clientTypeInvoices["$clientType->name"] = $invoiceTotal;
        }
        $this->expenseTotal = Expense::query()->whereBetween('date_incurred', [$this->dateStart, $this->dateEnd])->sum('price');
        $this->showData     = true;
    }

}
