<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>{{ $client->name }}</h1>
            <p>
                Update information for this client.
            </p>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types/show', $client->client_type_id) }}">
                <i class="fas {{ $client->clientType->icon }} me-1"></i>
                {{ $client->clientType->name }} Clients
            </a>
            <a class="btn btn-primary" href="{{ url('clients/show', $client) }}">
                <i class="fas fa-eye me-1"></i>
                View Client
            </a>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <x-error></x-error>
            <div class="col-md-4">
                <label for="name">Name</label>
                <input class="form-control" placeholder="Client name" wire:model="client.name" wire:change="update('client.name')" />
            </div>
            <div class="col-md-4">
                <label for="email">Email</label>
                <input class="form-control" placeholder="Client email" type="email" wire:model="client.email" wire:change="update('client.email')" />
            </div>
            <div class="col-md-4">
                <label for="email">Phone</label>
                <input class="form-control" placeholder="Client phone" wire:model="client.phone" wire:change="update('client.phone')" />
            </div>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Address</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="name">Name</label>
                <input
                    class="form-control"
                    placeholder="Address name"
                    wire:model.defer="client.address.name"
                    wire:change.defer="updateAddress('client.address.name')"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 1</label>
                <input
                    class="form-control"
                    placeholder="Address 1"
                    wire:model.defer="client.address.address_1"
                    wire:change.defer="updateAddress('client.address.address_1')"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 2</label>
                <input
                    class="form-control"
                    placeholder="Address 2"
                    wire:model.defer="client.address.address_2"
                    wire:change.defer="updateAddress('client.address.address_2')"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 3</label>
                <input
                    class="form-control"
                    placeholder="Address 3"
                    wire:model.defer="client.address.address_3"
                    wire:change.defer="updateAddress('client.address.address_3')"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Postcode</label>
                <input
                    class="form-control"
                    placeholder="Postcode"
                    wire:model.defer="client.address.postcode"
                    wire:change.defer="updateAddress('client.address.postcode')"
                />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-body mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Projects</h3>
                        <p>Invoices can be associated with a client project.</p>
                        <div class="mb-3">
                            @foreach($client->projects as $key=>$project)
                                <div class="d-flex mb-2">
                                    <input
                                        class="form-control"
                                        placeholder="Name"
                                        wire:model="client.projects.{{ $key }}.name"
                                        wire:change.defer="updateProject('client.projects.{{ $key }}.name')"
                                    />
                                    <button class="btn btn-danger btn-sm ms-2" wire:click="destroyProject({{ $project->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                            <input class="form-control" placeholder="Add new project" wire:model="projectName" wire:change="storeProject()" />
                        </div>
                        <button class="btn btn-outline-primary" wire:click="addProject()">Add Project</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Businesses</h3>
                        <p>Invoices can be associated with a client business.</p>
                        <div class="mb-3">
                            @foreach($client->businesses as $key=>$business)
                                <div class="d-flex mb-2">
                                    <input
                                        class="form-control"
                                        placeholder="Name"
                                        wire:model="client.businesses.{{ $key }}.name"
                                        wire:change.defer="updateBusiness('client.businesses.{{ $key }}.name')"
                                    />
                                    <button class="btn btn-danger btn-sm ms-2" wire:click="destroyBusiness({{ $business->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                            <input class="form-control" placeholder="Add new business" wire:model="businessName" wire:change="storeBusiness()" />
                        </div>
                        <button class="btn btn-outline-primary" wire:click="addBusiness()">Add Business</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($client->invoices_count === 0)
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-danger w-100" wire:click="destroy()">Delete Client</button>
            </div>
        </div>
    @endif
</div>
