<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Statements</h1>
            <p class="mb-0">Get data from system.</p>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Date Start</label>
                <input class="form-control date-picker" placeholder="Date Start" wire:model.defer="dateStart" />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-md-6 mb-3">
                <label>Date End</label>
                <input class="form-control date-picker" placeholder="Date End" wire:model.defer="dateEnd" />
                <label class="fas fa-calendar-alt icon_input"></label>
            </div>
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" wire:click="getData()">
                    Get Data
                    <i class="fas fa-chart-area ms-1"></i>
                </button>
            </div>
        </div>
    </div>
    @if($showData)
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <p class="mb-0">Data for between {{ date('d/m/Y', strtotime($dateStart)) }} and {{ date('d/m/Y', strtotime($dateEnd)) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 pt-2 pb-2 border-bottom">
                    <h4>Income</h4>
                    @foreach($clientTypeInvoices as $key=>$clientTypeInvoice)
                        <div class="d-flex justify-content-between pb-2">
                            <span>{{ $key }}</span>
                            <span>{{ CurrencyHelper::getFormattedValue($clientTypeInvoice) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 pt-2 pb-2 border-bottom">
                    <div class="d-flex justify-content-between">
                        <h4>Expenses</h4>
                        <span>{{ CurrencyHelper::getFormattedValue($expenseTotal) }}</span>
                    </div>
                </div>
                <div class="col-md-12 pt-2 pb-2">
                    <div class="d-flex justify-content-between fw-bold">
                        <h4>Net Profit</h4>
                        <span>{{ CurrencyHelper::getFormattedValue(array_sum($clientTypeInvoices) - $expenseTotal) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>