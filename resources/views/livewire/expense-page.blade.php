<div id="page" class="container">
    <x-session-message></x-session-message>
    <x-notification></x-notification>
    <div class="row">
        <div class="col-md-12">
            <h1>Expenses</h1>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <h3>Add New Expense</h3>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="name">Description</label>
                    <input class="form-control" placeholder="Expense description" required wire:model="description" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Price (in pence)</label>
                    <input class="form-control" placeholder="Expense price" type="number" wire:model="price" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Date incurred</label>
                    <input class="form-control date-picker" placeholder="Date incurred" wire:model="date_incurred" />
                </div>
                <div class="col-md-6">
                    <label for="vat_included">VAT included?</label>
                    <input class="form-check" type="checkbox" checked wire:model="vat_included" />
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-success" wire:click="store()" @if(!$description) disabled @endif>Add Expense</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-end mt-3">
            <span>Current Tax Year Expenses: <span class="fw-bold">{{ $currentTaxYearTotal }}</span></span>
            <a class="btn btn-primary ms-3" href="{{ url('exports/expenses') }}">
                Export All
                <i class="fas fa-file-excel ms-1"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                @livewire('expense-table-row-component')
            </div>
        </div>
    </div>
</div>
