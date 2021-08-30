<?php

namespace App\Http\Livewire;

use App\Models\{Invoice, InvoiceItem};
use Livewire\Component;

class InvoiceItemComponent extends Component
{

    public Invoice $invoice;
    public array $ids = [];
    public array $descriptions = [];
    public array $prices = [];
    public array $hourss = [];
    public array $renewalRequireds = [];
    public int $invoiceItemCount = 1;

    public function rules(): array
    {
        return [
            'ids.*'              => 'nullable|integer',
            'descriptions.*'     => 'nullable|string',
            'prices.*'           => 'nullable|integer',
            'hourss.*'           => 'nullable|integer',
            'renewalRequireds.*' => 'nullable|string',
        ];
    }

    public function render()
    {
        return view('livewire.invoice-item-component');
    }

    public function storeOrUpdate($index)
    {
        if ($this->descriptions[$index] !== '') {
            $invoiceItem = $this->invoice->invoiceItems()->updateOrCreate([
                'id' => $this->ids[$index]
            ], [
                'description'      => $this->descriptions[$index],
                'price'            => $this->prices[$index],
                'hours'            => $this->hourss[$index],
                'renewal_required' => $this->renewalRequireds[$index],
            ]);
            if ($invoiceItem->wasRecentlyCreated) {
                $this->ids[$index] = $invoiceItem->id;
                $this->dispatchBrowserEvent(
                    'notify', ['type' => 'success', 'message' => 'Invoice Item Created']
                );
            } else if ($invoiceItem) {
                $this->dispatchBrowserEvent(
                    'notify', ['message' => 'Invoice Item Updated']
                );
            }
        }
    }

    public function mount()
    {
        $this->setInitialInputs();
    }

    public function destroy(int $index)
    {
        $invoiceItem = InvoiceItem::find($this->ids[$index]);
        $invoiceItem->delete();
        $this->setInitialInputs();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Invoice Item Removed']
        );
    }

    public function add()
    {
        $this->invoiceItemCount++;
        array_push($this->ids, NULL);
        array_push($this->descriptions, '');
        array_push($this->prices, 0);
        array_push($this->hourss, 0);
        array_push($this->renewalRequireds, NULL);
    }

    public function setInitialInputs()
    {

        foreach ($this->invoice->invoiceItems as $invoiceItem) {
            array_push($this->ids, $invoiceItem->id);
            array_push($this->descriptions, $invoiceItem->description);
            array_push($this->prices, $invoiceItem->price);
            array_push($this->hourss, $invoiceItem->hours);
            array_push($this->renewalRequireds, $invoiceItem->renewal_required);
        }
        array_push($this->ids, NULL);
        array_push($this->descriptions, '');
        array_push($this->prices, 0);
        array_push($this->hourss, 0);
        array_push($this->renewalRequireds, NULL);

        $this->invoiceItemCount = max($this->invoice->invoiceItems->count(), 1);

    }

}
