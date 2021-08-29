@extends('layouts.app')
@section('page-title', 'Create Client Type')
@section('content')
<div id="page" class="container">
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Create Client Type</h1>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types') }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Client Types
            </a>
        </div>
    </div>
    <div class="card card-body">
        <form class="row" method="POST" action="{{ url('client-types') }}">
            @csrf
            <x-error></x-error>
            <div class="mb-3 col-md-8">
                <label class="control-label" for="name">Name</label>
                <input id="name" class="form-control" name="name" value="{{ old('name') }}" placeholder="Client type name" required />
            </div>
            <div class="mb-3 col-md-4">
                <label class="control-label" for="icon">Icon</label>
                <input id="icon" class="form-control" name="icon" value="{{ old('icon') }}" placeholder="Client type icon" />
            </div>
            <div class="mb-3 col-md-12">
                <label class="control-label" for="description">Description</label>
                <textarea id="description" class="form-control" name="description" placeholder="Client type description">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Create Client Type
                    <i class="fas fa-plus ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
