<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>{{ $client->name }}</h1>
            <p class="mb-0">All invoices for this client.</p>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types/show/'.$client->client_type_id) }}">
                <i class="fas {{ $client->clientType->icon }} me-1"></i>
                {{ $client->clientType->name }} Clients
            </a>
            <a class="btn btn-primary" href="{{ url('clients/edit', $client) }}">
                <i class="fas fa-wrench me-1"></i>
                Edit Client
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <h3>Add New Invoice</h3>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Total (in pence)</label>
                    <input class="form-control" type="number" wire:model.lazy="invoiceTotal" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name">Invoice status <span class="asterisk">*</span></label>
                    <select class="form-control" wire:model.lazy="invoiceDateStatusId">
                        @foreach($invoiceStatuses as $invoiceStatus)
                            <option
                                value="{{ $invoiceStatus->id }}" @if((int)$invoiceStatus->id === App\Models\InvoiceStatus::SENT) selected @endif
                            >
                                {{ $invoiceStatus->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name">Date sent</label>
                    <input class="form-control date-picker" type="text" placeholder="Date sent" wire:model.lazy="invoiceDateSent" />
                    <label class="fas fa-calendar-alt icon_input"></label>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name">Date paid</label>
                    <input class="form-control date-picker" type="text" placeholder="Date paid" wire:model.lazy="invoiceDatePaid" />
                    <label class="fas fa-calendar-alt icon_input"></label>
                </div>
                <div class="col-md-12 mt-3 text-end">
                    <button class="btn btn-success" wire:click="storeInvoice()" @if(!$invoiceTotal) disabled @endif>Add New Invoice</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Invoices</h3>
                    <h4>Total (paid): {{ $invoiceSum }}</h4>
                </div>
            </div>
            <div class="col-md-12">
                @livewire('client-invoice-table-row-component', ['client' => $client])
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Files</h3>
            </div>
            <div class="col-md-12">
                @livewire('client-media-table-row-component', ['client' => $client])
            </div>
        </div>
    </div>
    <x-filepond :files="$files"></x-filepond>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Comments</h3>
            </div>
            <div class="col-md-12 mb-3">
                @forelse($client->comments as $comment)
                    <div class="border mb-3 mt-3 rounded">
                        <div class="d-flex flex-column comment-section">
                            <div class="p-2 bg-light">
                                <div class="d-flex flex-row justify-content-between align-items-start">
                                    <div class="d-flex flex-column justify-content-start ml-2">
                                        <span class="date text-black-50">{{ date('H:i d/m/Y', strtotime($comment->created_at)) }}</span>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="destroyComment({{ $comment->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <?php echo $comment->description; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <span class="fst-italic">There are no comments for this client yet.</span>
                @endforelse
            </div>
            <x-error></x-error>
            <div class="col-md-12">
                <label>New Comment</label>
                <textarea class="form-control mb-3" rows="3" wire:model="commentDescription"></textarea>
                <div class="text-end">
                    <button class="btn btn-outline-success" wire:click="storeComment()">
                        Add Comment
                        <i class="fas fa-comment ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
