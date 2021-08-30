<div class="card card-body mb-3">
    <div class="row">
        <div class="col-md-12">
            <h3>Invoice Payments</h3>
            <p>Each payment received from the client to fulfil payment.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @foreach($invoice->invoicePayments as $invoicePayment)
                <div class="p-3 mb-3 @if($loop->iteration % 2 != 0) bg-light @endif">
                    <h5>Payment #{{ $loop->iteration }}</h5>
                    <div class="d-flex align-items-end mb-3">
                        <input type="hidden" wire:model="ids.{{ $loop->index }}" />
                        <div class="w-50">
                            <label>Date Paid</label>
                            <input class="form-control date-picker" type="text" placeholder="Date paid" wire:model="datePaids.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})" />
                        </div>
                        <div class="w-50 ms-2">
                            <label>Total</label>
                            <input class="form-control" placeholder="Price" type="number" wire:model="totals.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})" />
                        </div>
                        <div class="w-25 ms-2">
                            <button class="btn btn-outline-danger w-100" wire:click="destroy({{ $loop->index }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            @for($i=$invoice->invoicePayments->count(); $i<$invoicePaymentCount; $i++)
                <div class="p-3 mb-3 @if($i % 2 != 0) bg-light @endif">
                    <h5>Payment #{{ $i+1 }}</h5>
                    <div class="d-flex align-items-end mb-3">
                        <input type="hidden" wire:model="ids.{{ $i }}" />
                        <div class="w-50">
                            <label>Date Paid</label>
                            <input class="form-control date-picker" type="text" placeholder="Date paid" wire:model="datePaids.{{ $i }}" wire:change="storeOrUpdate({{ $i }})" />
                        </div>
                        <div class="w-50 ms-2">
                            <label>Total</label>
                            <input class="form-control ms-2" placeholder="Price" type="number" wire:model="totals.{{ $i }}" wire:change="storeOrUpdate({{ $i }})" />
                        </div>
                    </div>
                </div>
                <script>
                    flatpickr(".date-picker", {
                        enableTime: false,
                        dateFormat: "Y-m-d",
                        time_24hr: false,
                        onChange: function(selectedDates, dateStr, instance){
                            if( dateStr === '') { instance.close(); }
                        }
                    });
                </script>
            @endfor
        </div>
        <div class="col-md-12 mt-3 text-end">
            <button class="btn btn-outline-success" wire:click="add()">
                Add New Payment
                <i class="fas fa-plus ms-1"></i>
            </button>
        </div>
    </div>
</div>