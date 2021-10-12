<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>File Storage</h1>
            <p class="mb-0">Files not linked to clients etc.</p>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                @livewire('media-table-row-component')
            </div>
        </div>
    </div>
    <x-filepond :files="$files"></x-filepond>
</div>
