<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $clientType->name }} Clients</h1>
        </div>
    </div>
    <div class="row mb-3">
        <x-error></x-error>
        <div class="col-md-12">
            <h3>Add New Client</h3>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Name <span class="asterisk">*</span></label>
                    <input class="form-control" placeholder="Client name" wire:model="name" />
                </div>
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input class="form-control" placeholder="Client email" type="email" wire:model="email" />
                </div>
                <div class="col-md-12 mt-3 text-end">
                    <button class="btn btn-success" wire:click="store()" @if(!$name) disabled @endif>Add Client</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="table_col_width_20">Name</th>
                            <th class="table_col_width_25">Email</th>
                            <th>Businesses</th>
                            <th class="table_center table_col_width_15">Latest Invoice</th>
                            <th class="table_center table_col_width_5">View</th>
                            <th class="table_center table_col_width_5">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>
                                    @foreach($client->businesses as $business)
                                        {{ $business->name }}@if(!$loop->last),@endif
                                    @endforeach
                                </td>
                                <td class="table_center">
                                    {{ $client->lastInvoice->date_sent ?? '-' }}
                                </td>
                                <td class="table_center">
                                    <a class="btn btn-primary btn-sm" href="{{ url('clients/show', $client) }}">
                                        <i class="fas fa-eye text-white" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="table_center">
                                    <a class="btn btn-warning btn-sm" href="{{ url('clients/edit', $client) }}">
                                        <i class="fas fa-wrench text-white" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
