<div class="card card-body mb-3">
    <div class="row">
        <div class="col-md-12">
            <h3>Invoice Items</h3>
            <p>Individual parts of work completed as part of the job.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @foreach($invoice->invoiceItems as $invoiceItem)
                <div class="p-3 mb-3 @if($loop->iteration % 2 != 0) bg-light @endif">
                    <h5>Item #{{ $loop->iteration }}</h5>
                    <label>Description</label>
                    <textarea class="form-control mb-2" rows="4" wire:model="descriptions.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})"></textarea>
                    <div class="d-flex align-items-end mb-3">
                        <input type="hidden" wire:model="ids.{{ $loop->index }}" />
                        <div class="w-25">
                            <label>Price</label>
                            <input class="form-control" type="number" wire:model="prices.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})" placeholder="Price" />
                        </div>
                        <div class="w-25 ms-2">
                            <label>Hours</label>
                            <input class="form-control" type="number" wire:model="hourss.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})" placeholder="Hours" />
                        </div>
                        <div class="w-25 ms-2">
                            <label>Renewal Required?</label>
                            <input class="form-control date-picker" wire:model="renewalRequireds.{{ $loop->index }}" wire:change="storeOrUpdate({{ $loop->index }})" placeholder="Renewal date" />
                        </div>
                        <div class="w-25 ms-2">
                            <button class="btn btn-outline-danger w-100" wire:click="destroy({{ $loop->index }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            @for($i=$invoice->invoiceItems->count(); $i<$invoiceItemCount; $i++)
                <div class="p-3 mb-3 @if($i % 2 != 0) bg-light @endif">
                    <h5>Item #{{ $i+1 }}</h5>
                    <label>Description</label>
                    <textarea class="form-control mb-2" rows="4" wire:model="descriptions.{{ $i }}" wire:change="storeOrUpdate({{ $i }})"></textarea>
                    <div class="d-flex align-items-end mb-3">
                        <input type="hidden" wire:model="ids.{{ $i }}" />
                        <div class="w-25">
                            <label>Price</label>
                            <input class="form-control" type="number" wire:model="prices.{{ $i }}" wire:change="storeOrUpdate({{ $i }})" placeholder="Price" />
                        </div>
                        <div class="w-25 ms-2">
                            <label>Hours</label>
                            <input class="form-control" type="number" wire:model="hourss.{{ $i }}" wire:change="storeOrUpdate({{ $i }})" placeholder="Hours" />
                        </div>
                        <div class="w-25 ms-2">
                            <label>Renewal Required?</label>
                            <input class="form-control date-picker" wire:model="renewalRequireds.{{ $i }}" wire:change="storeOrUpdate({{ $i }})" placeholder="Renewal date" />
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
                    </div>
                </div>
            @endfor
        </div>
        <div class="col-md-12 mt-3 text-end">
            <button class="btn btn-outline-success" wire:click="add()">
                Add New Item
                <i class="fas fa-plus ms-1"></i>
            </button>
        </div>
    </div>
</div>