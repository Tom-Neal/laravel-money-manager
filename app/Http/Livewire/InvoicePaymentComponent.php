<?php

namespace App\Http\Livewire;

use App\Models\{Invoice, InvoicePayment};
use Livewire\Component;

class InvoicePaymentComponent extends Component
{

    public Invoice $invoice;
    public array $ids = [];
    public array $totals = [];
    public array $datePaids = [];
    public int $invoicePaymentCount = 1;

    public function render()
    {
        return view('livewire.invoice-payment-component');
    }

    public function storeOrUpdate($index)
    {
        if ($this->datePaids[$index] !== '') {
            $invoicePayment = $this->invoice->invoicePayments()->updateOrCreate([
                'id' => $this->ids[$index]
            ], [
                'total'     => $this->totals[$index],
                'date_paid' => $this->datePaids[$index],
            ]);
            if ($invoicePayment->wasRecentlyCreated) {
                $this->ids[$index] = $invoicePayment->id;
                $this->dispatchBrowserEvent(
                    'notify', ['type' => 'success', 'message' => 'Invoice Payment Created']
                );
            } else if ($invoicePayment) {
                $this->dispatchBrowserEvent(
                    'notify', ['message' => 'Invoice Payment Updated']
                );
            }
        }
    }

    public function mount()
    {
        $this->setInitialInputs();
    }

    public function destroy($index)
    {
        $invoicePayment = InvoicePayment::find($this->ids[$index]);
        $invoicePayment->delete();
        $this->invoice->refresh();
        $this->setInitialInputs();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Invoice Payment Removed']
        );
    }

    public function add()
    {
        $this->invoicePaymentCount++;
        array_push($this->ids, NULL);
        array_push($this->totals, 0);
        array_push($this->datePaids, NULL);
    }

    public function setInitialInputs()
    {

        foreach ($this->invoice->invoicePayments as $invoicePayment) {
            array_push($this->ids, $invoicePayment->id);
            array_push($this->totals, $invoicePayment->total);
            array_push($this->datePaids, $invoicePayment->date_paid);
        }
        array_push($this->ids, NULL);
        array_push($this->totals, 0);
        array_push($this->datePaids, NULL);

        $this->invoicePaymentCount = max([$this->invoice->invoicePayments->count(), 1]);

    }

}
