<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Invoice {{ $invoice->number_formatted }}</h1>
        </div>
        <div class="col-lg-auto d-grid gap-2 d-lg-flex justify-content-lg-end mt-2">
            <a class="btn btn-primary" href="{{ url('clients/show', $invoice->client_id) }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Client
            </a>
        </div>
    </div>
    @if(!$invoice->invoicePaymentTotalCheck())
        <div class="row">
            <div class="col-lg-12">
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
                <label for="number">#</label>
                <input class="form-control" wire:model.lazy="invoice.number" wire:change="update('invoice.number')" />
            </div>
            <div class="col-lg-2 mb-3">
                <label for="total">Total (in pence)</label>
                <input class="form-control" type="number" wire:model.lazy="invoice.total" wire:change="update('invoice.total')" />
            </div>
            <div class="col-lg-2 mb-3">
                <label for="invoice_status_id">Invoice status</label>
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
                <label for="date_sent">Date sent</label>
                <input
                    class="form-control input-reset"
                    type="text"
                    placeholder="Date sent"
                    wire:model.lazy="invoice.date_sent"
                    x-data
                    x-init="flatpickr($refs.input, {
                        onChange: function(dateObj, dateStr) {
                            @this.call('update', {{ $invoice->date_sent }}, dateStr)
                        }
                      });"
                    x-ref="input"
                />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="date_paid">Date paid</label>
                <input
                    class="form-control input-reset"
                    type="text"
                    placeholder="Date paid"
                    wire:model.lazy="invoice.date_paid"
                    x-data
                    x-init="flatpickr($refs.input, {
                        onChange: function(dateObj, dateStr) {
                            @this.call('update', {{ $invoice->date_paid }}, dateStr)
                        }
                      });"
                    x-ref="input"
                />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="business_id">Business</label>
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
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-lg-12">
                <h3>Invoice Items</h3>
                <p>Individual parts of work completed as part of the job.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @foreach($invoice->items as $key=>$item)
                    <div class="p-3 mb-3 @if($loop->iteration % 2 != 0) bg-light @endif">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5>Item #{{ $loop->iteration }}</h5>
                            </div>
                            <div class="col-lg-12">
                                <label>Description</label>
                                <textarea
                                    class="form-control mb-2"
                                    rows="4"
                                    placeholder="Item description"
                                    wire:model.defer="invoice.items.{{ $key }}.description"
                                    wire:change.defer="updateInvoiceItem('invoice.items.{{ $key }}.description')"
                                ></textarea>
                            </div>
                            <div class="col-lg-3">
                                <label>Price</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    placeholder="Price"
                                    wire:model.defer="invoice.items.{{ $key }}.price"
                                    wire:change.defer="updateInvoiceItem('invoice.items.{{ $key }}.price')"
                                />
                            </div>
                            <div class="col-lg-3">
                                <label>Hours</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    placeholder="Hours"
                                    wire:model.defer="invoice.items.{{ $key }}.hours"
                                    wire:change.defer="updateInvoiceItem('invoice.items.{{ $key }}.hours')"
                                />
                            </div>
                            <div class="col-lg-3">
                                <label>Renewal Required?</label>
                                <input
                                    class="form-control input-white"
                                    wire:model.defer="invoice.items.{{ $key }}.renewal_required"
                                    x-data
                                    x-init="flatpickr($refs.input, {
                                        onChange: function(dateObj, dateStr) {
                                            @this.call('updateInvoiceItemRenewalRequired', {{ $item->id }}, dateStr)
                                        }
                                      });"
                                    x-ref="input"
                                    type="text"
                                />
                            </div>
                            <div class="col-lg-1 offset-lg-2">
                                <label style="opacity: 0">Delete</label>
                                <button class="btn btn-outline-danger w-100" wire:click="destroyInvoiceItem({{ $item->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="p-3 mb-3 border-top">
                    <h5>New Invoice Item</h5>
                    <label>Description</label>
                    <input
                        class="form-control mb-2"
                        placeholder="Start by adding the item description"
                        wire:model="invoiceItemDescription"
                        wire:change="storeInvoiceItem()"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-lg-12">
                <h3>Invoice Payments</h3>
                <p>Each payment received from the client to fulfil payment.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @foreach($invoice->payments as $key=>$payment)
                    <div class="p-3 @if($loop->iteration % 2 != 0) bg-light @endif">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5>Payment #{{ $loop->iteration }}</h5>
                            </div>
                            <div class="col-lg-3">
                                <label>Total</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    placeholder="Total"
                                    wire:model.defer="invoice.payments.{{ $key }}.total"
                                    wire:change.defer="updateInvoicePayment('invoice.payments.{{ $key }}.total')"
                                />
                            </div>
                            <div class="col-lg-3">
                                <label>Date Paid</label>
                                <input
                                    class="form-control input-white"
                                    wire:model.defer="invoice.payments.{{ $key }}.date_paid"
                                    x-data
                                    x-init="flatpickr($refs.input, {
                                        onChange: function(dateObj, dateStr) {
                                            @this.call('updateInvoicePaymentDatePaid', {{ $payment->id }}, dateStr)
                                        }
                                      });"
                                    x-ref="input"
                                    type="text"
                                />
                            </div>
                            <div class="col-lg-1 offset-lg-5">
                                <label style="opacity: 0">Delete</label>
                                <button class="btn btn-outline-danger w-100" wire:click="destroyInvoicePayment({{ $payment->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="p-3 mb-3 border-top">
                    <h5>New Invoice Payment</h5>
                    <label>Total</label>
                    <input
                        class="form-control mb-2 w-25"
                        type="number"
                        placeholder="Total"
                        wire:model="invoicePaymentTotal"
                        wire:change="storeInvoicePayment()"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-danger w-100" wire:click="destroyConfirm()">
                Delete Invoice
                <i class="fas fa-times ms-1"></i>
            </button>
        </div>
    </div>
</div>
