<?php

namespace App\Http\Livewire;

use App\Models\{Invoice, InvoiceStatus};
use Livewire\Component;

class InvoicePage extends Component
{

    public Invoice $invoice;
    public $invoiceStatuses;

    public function rules(): array
    {
        return [
            'invoice.number'            => 'required|string',
            'invoice.total'             => 'nullable|integer',
            'invoice.date_sent'         => 'nullable|string',
            'invoice.date_paid'         => 'nullable|string',
            'invoice.invoice_status_id' => 'required|integer',
        ];
    }

    public function render()
    {
        $this->invoice->load('invoiceItems', 'invoicePayments');
        return view('livewire.invoice-page');
    }

    public function mount()
    {
        $this->invoiceStatuses = InvoiceStatus::all();
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->invoice->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Updated']
        );
    }

    public function destroy()
    {
        $clientId = $this->invoice->client_id;
        $this->invoice->delete();
        return redirect()->to("clients/show/$clientId");
    }

}
