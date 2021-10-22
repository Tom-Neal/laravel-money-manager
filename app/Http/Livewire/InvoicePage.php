<?php

namespace App\Http\Livewire;

use App\Models\{Invoice, InvoiceItem, InvoicePayment, InvoiceStatus};
use Livewire\Component;

class InvoicePage extends Component
{

    public Invoice $invoice;
    public $invoiceStatuses;
    public string $invoiceItemDescription = '';
    public int $invoicePaymentTotal = 0;

    public $listeners = ['destroy'];

    public function rules(): array
    {
        return [
            'invoice.number'                     => 'required|string',
            'invoice.total'                      => 'nullable|integer',
            'invoice.date_sent'                  => 'nullable|string',
            'invoice.date_paid'                  => 'nullable|string',
            'invoice.invoice_status_id'          => 'required|integer',
            'invoice.business_id'                => 'nullable',
            'invoice.items.*.description'        => 'required|string',
            'invoice.items.*.price'              => 'nullable|integer',
            'invoice.items.*.hours'              => 'nullable|integer',
            'invoice.items.*.renewal_required'   => 'nullable|string',
            'invoice.payments.*.total'           => 'required|integer',
            'invoice.payments.*.date_paid'       => 'nullable|string',
        ];
    }

    public function render()
    {
        $this->invoice->load('items', 'payments');
        return view('livewire.invoice-page');
    }

    public function mount()
    {
        $this->invoiceStatuses = InvoiceStatus::all();
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
        // Workaround to address empty string !== NULL
        $this->invoice->business_id = $this->invoice->business_id ? : NULL;
        $this->invoice->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Updated']
        );
    }

    public function destroy()
    {
        $clientId = $this->invoice->client_id;
        $this->invoice->delete();
        return redirect()->to("clients/show/$clientId")
            ->with('message', 'Invoice Deleted');
    }

    public function destroyConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type'              => 'warning',
            'title'             => 'Attention!',
            'text'              => 'Are you sure you want to delete this invoice?',
            'confirmButtonText' => 'Delete',
            'id'                => $this->invoice->id
        ]);
    }

    public function storeInvoiceItem()
    {
        if($this->invoiceItemDescription) {
            $this->invoice->items()->create([
                'description'  => $this->invoiceItemDescription,
                'price'        => 0,
            ]);
        }
        $this->invoice->refresh();
        $this->invoiceItemDescription = '';
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Invoice Item Added']
        );
    }

    public function updateInvoiceItem($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->invoice->items->load('invoice')->each->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Item Updated']
        );
    }

    public function updateInvoiceItemRenewalRequired(InvoiceItem $invoiceItem, $date)
    {
        // Workaround for datepicker issues
        $invoiceItem->update([
            'renewal_required' => $date ?: NULL
        ]);
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Item Updated']
        );
    }

    public function destroyInvoiceItem(InvoiceItem $invoiceItem)
    {
        $invoiceItem->delete();
        $this->invoice->refresh();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Invoice Item Deleted']
        );
    }

    public function storeInvoicePayment()
    {
        if($this->invoicePaymentTotal) {
            $this->invoice->payments()->create([
                'total' => $this->invoicePaymentTotal
            ]);
        }
        $this->invoice->refresh();
        $this->invoicePaymentTotal = 0;
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Invoice Payment Added']
        );
    }

    public function updateInvoicePayment($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->invoice->payments->load('invoice')->each->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Payment Updated']
        );
    }

    public function updateInvoicePaymentDatePaid(InvoicePayment $invoicePayment, $date)
    {
        // Workaround for datepicker issues
        $invoicePayment->update([
            'date_paid' => $date ?: NULL
        ]);
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Invoice Payment Updated']
        );
    }

    public function destroyInvoicePayment(InvoicePayment $invoicePayment)
    {
        $invoicePayment->delete();
        $this->invoice->refresh();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Invoice Payment Deleted']
        );
    }

}
