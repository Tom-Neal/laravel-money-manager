<div id="page" class="container">
    <x-session-message></x-session-message>
    <x-notification></x-notification>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>{{ $client->name }}</h1>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types/show', $client->client_type_id) }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Web Development Clients
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
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-danger w-100" wire:click="destroy()">Delete</button>
        </div>
    </div>
</div>
