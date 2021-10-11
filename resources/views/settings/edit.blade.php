@extends('layouts.app')
@section('page-title', 'Application Settings')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row">
        <div class="col-md-12">
            <h1>{{ config('app.name') }} Settings</h1>
            <p>Update settings used throughout the application.</p>
        </div>
    </div>
    <div class="card card-body p-4">
        <form class="row" method="POST" action="{{ url('settings', $settings) }}">
            @method('PATCH')
            @csrf
            <x-error></x-error>
            <div class="mb-3 col-md-6">
                <label for="name">Name <span class="asterisk">*</span></label>
                <input
                    id="name"
                    class="form-control"
                    name="name"
                    value="{{ old('name', $settings->name) }}"
                    type="text"
                    required
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="email">Email <span class="asterisk">*</span></label>
                <input
                    id="email"
                    class="form-control"
                    name="email"
                    value="{{ old('email', $settings->email) }}"
                    type="email"
                    required
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="phone">Phone Number</label>
                <input
                    id="phone"
                    class="form-control"
                    name="phone"
                    value="{{ old('phone', $settings->phone) }}"
                    type="text"
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="google_map_api_key">Google Maps API Key</label>
                <input
                    id="google_map_api_key"
                    class="form-control"
                    name="google_map_api_key"
                    value="{{ old('google_map_api_key', $settings->google_map_api_key) }}"
                    type="text"
                />
            </div>
            <div class="col-md-12 mb-3">
                <label for="name">Address Name</label>
                <input
                    class="form-control"
                    placeholder="Address name"
                    name="address_name"
                    value="{{ old('address_name', $settings->address->name) }}"
                    type="text"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 1</label>
                <input
                    class="form-control"
                    placeholder="Address 1"
                    name="address_1"
                    value="{{ old('address_1', $settings->address->address_1) }}"
                    type="text"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 2</label>
                <input
                    class="form-control"
                    placeholder="Address 2"
                    name="address_2"
                    value="{{ old('address_2', $settings->address->address_2) }}"
                    type="text"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Address 3</label>
                <input
                    class="form-control"
                    placeholder="Address 3"
                    name="address_3"
                    value="{{ old('address_3', $settings->address->address_3) }}"
                    type="text"
                />
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Postcode</label>
                <input
                    class="form-control"
                    placeholder="Postcode"
                    name="postcode"
                    value="{{ old('postcode', $settings->address->postcode) }}"
                    type="text"
                />
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Update Settings
                    <i class="fas fa-wrench ms-1" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
