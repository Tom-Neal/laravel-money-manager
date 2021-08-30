<div id="page" class="container">
    <x-session-message></x-session-message>
    <x-notification></x-notification>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>{{ $client->name }}</h1>
            <p class="mb-0">All invoices and comments for this client.</p>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types/show/'.$client->client_type_id) }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to {{ $client->clientType->name }} Clients
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
                    <button class="btn btn-success" wire:click="storeInvoice()">Add New Invoice</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Invoices ({{ $client->invoices->count() }})</h3>
            </div>
            <div class="col-md-12">
                @if($client->invoices->isNotEmpty())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="table_center table_col_width_5">Number</th>
                                <th>First Item</th>
                                <th class="table_center table_col_width_15">Date Sent</th>
                                <th class="table_center table_col_width_15">Latest Payment</th>
                                <th class="table_center table_col_width_10">Total</th>
                                <th class="table_center table_col_width_15">Status</th>
                                <th class="table_center table_col_width_5">PDF</th>
                                <th class="table_center table_col_width_5">Send</th>
                                <th class="table_center table_col_width_5">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->invoices as $invoice)
                                <tr>
                                    <td class="table_center">{{ $invoice->number }}</td>
                                    <td>{{ $invoice->firstInvoiceItem->description ?? '' }}</td>
                                    <td class="table_center">{{ $invoice->date_sent }}</td>
                                    <td class="table_center">{{ $invoice->lastPayment->date_paid ?? '' }}</td>
                                    <td class="table_center">{{ $invoice->total_formatted }}</td>
                                    <td class="table_center">
                                        <span class="fw-bold w-50 py-2 badge bg-{{ $invoice->invoiceStatus->colour }}">
                                            {{ $invoice->invoiceStatus->name }}
                                        </span>
                                    </td>
                                    <td class="table_center">
                                        @if($invoice->downloadCheck())
                                            <a class="btn btn-primary btn-sm" href="{{ url('invoices/download', $invoice) }}">
                                                <i class="fas fa-download text-white" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="table_center">
                                        @if($invoice->downloadCheck() && $invoice->client->email)
                                            <a class="btn btn-info btn-sm" href="{{ url('invoices/mails', $invoice) }}">
                                                <i class="fas fa-envelope text-white" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="table_center">
                                        <a class="btn btn-warning btn-sm" href="{{ url('invoices/edit', $invoice) }}">
                                            <i class="fas fa-wrench text-white" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="fst-italic">There are no invoices yet.</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Files ({{ $client->media->count() }})</h3>
            </div>
        </div>
        @if($client->media->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th class="table_center table_col_width_5">Download</th>
                            <th class="table_center table_col_width_5">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->media as $file)
                            <tr>
                                <td>{{ $file->name }}</td>
                                <td class="table_center">
                                    <a class="btn btn-primary btn-sm border border-primary border-2" href="{{ url('media', $file) }}" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                                <td class="table_center table_col_width_5">
                                    <button class="btn btn-danger btn-sm border border-danger border-2" wire:click="deleteConfirm({{ $file->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <span class="fst-italic">There are no files for this client yet.</span>
        @endif
    </div>
    <x-filepond :files="$files"></x-filepond>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Comments ({{ $client->comments->count() }})</h3>
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
