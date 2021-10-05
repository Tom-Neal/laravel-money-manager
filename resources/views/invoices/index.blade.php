@extends('layouts.app')
@section('page-title', 'Invoices')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row">
        <div class="col-md-12">
            <h1>Invoices</h1>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12">
                <h3>Invoices By Tax Year</h3>
                <p>All invoices for a tax year in one zip file, with payment details if paid in full as an option.</p>
            </div>
            <div class="col-md-12">
                @for($i=0; $i<5; $i++)
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                        <div>
                            <span>{{ $year }}-{{ $year+1 }}</span>
                        </div>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-sm me-1" href="{{ url("invoices/download/tax-year/$year") }}">
                                Download All
                                <i class="fas fa-download ms-1"></i>
                            </a>
                            <a class="btn btn-primary btn-sm ms-1" href="{{ url("invoices/with-payments/download/tax-year/$year") }}">
                                With Payments
                                <i class="fas fa-download ms-1"></i>
                            </a>
                        </div>
                    </div>
                    @php($year--)
                @endfor
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end align-items-end mb-2">
            <a class="btn btn-primary" href="{{ url('exports/invoices') }}">
                Export All
                <i class="fas fa-file-excel ms-1"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <h3>All Invoices</h3>
            </div>
            <div class="col-md-12">
                @livewire('invoice-table-row-component')
            </div>
        </div>
    </div>
</div>
@push('css')
    @livewireStyles
@endpush
@push('js')
    <script src="{{ asset('js/alpine-2.8.2/alpine.js') }}" defer></script>
    @livewireScripts
@endpush
@endsection
