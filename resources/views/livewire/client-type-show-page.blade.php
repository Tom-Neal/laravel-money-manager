<div id="page" class="container">
    <x-session-message></x-session-message>
    <x-notification></x-notification>
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
</div>
