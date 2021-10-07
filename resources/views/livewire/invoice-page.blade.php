<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Invoice {{ $invoice->number_formatted }}</h1>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('clients/show', $invoice->client_id) }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Client
            </a>
        </div>
    </div>
    @if(!$invoice->invoicePaymentTotalCheck())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <span class="fw-bold">Invoice payments do not add up to invoice total!</span>
                    <a class="close" data-bs-dismiss="alert" aria-label="Close">×</a>
                </div>
            </div>
        </div>
    @endif
    <div class="card card-body mb-3">
        <div class="row">
            <x-error></x-error>
            <div class="col-lg-2 mb-3">
                <label for="name">#</label>
                <input class="form-control" wire:model.lazy="invoice.number" wire:change="update('invoice.number')" />
            </div>
            <div class="col-lg-2 mb-3">
                <label for="name">Total (in pence)</label>
                <input class="form-control" type="number" wire:model.lazy="invoice.total" wire:change="update('invoice.total')" />
            </div>
            <div class="col-lg-2 mb-3">
                <label for="name">Invoice status</label>
                <select class="form-control text-{{ $invoice->invoiceStatus->colour }} fw-bold" wire:model.lazy="invoice.invoice_status_id" wire:change="update('invoice.invoice_status_id')">
                    @foreach($invoiceStatuses as $invoiceStatus)
                        <option
                            class="text-{{ $invoiceStatus->colour }} fw-bold"
                            value="{{ $invoiceStatus->id }}" @if((int)$invoiceStatus->id === App\Models\InvoiceStatus::SENT) selected @endif
                        >
                            {{ $invoiceStatus->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="name">Date sent</label>
                <input class="form-control date-picker" type="text" placeholder="Date sent" wire:model.lazy="invoice.date_sent" wire:change="update('invoice.date_sent')" />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="name">Date paid</label>
                <input class="form-control date-picker" type="text" placeholder="Date paid" wire:model.lazy="invoice.date_paid" wire:change="update('invoice.date_paid')" />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="name">Business</label>
                <select class="form-control" wire:model.lazy="invoice.business_id" wire:change="update('invoice.business_id')">
                    <option value="{{ NULL }}">-</option>
                    @foreach($invoice->client->businesses as $business)
                        <option
                            value="{{ $business->id }}" @if((int)$business->id === (int)$invoice->business_id) selected @endif
                        >
                            {{ $business->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @livewire('invoice-item-component', [
        'invoice' => $invoice
    ])
    @livewire('invoice-payment-component', [
        'invoice' => $invoice
    ])
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-danger w-100" wire:click="destroy()">
                Delete Invoice
                <i class="fas fa-times ms-1"></i>
            </button>
        </div>
    </div>
</div>
