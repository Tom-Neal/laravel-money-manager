@extends('layouts.app')
@section('page-title', 'Copy Invoice')
@section('content')
<div id="page" class="container">
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Copy Invoice</h1>
            <p>
                Copy this invoice to quickly create a new one with the same details - these details can then be modified.
            </p>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('invoices') }}">
                <i class="fas fa-arrow-left me-1"></i>
                All Invoices
            </a>
            <a class="btn btn-primary" href="{{ url('clients/show', $invoice->client_id) }}">
                <i class="fas fa-arrow-left me-1"></i>
                Client Invoices
            </a>
        </div>
    </div>
    <div class="card card-body">
        <form class="row" method="POST" action="{{ url('invoices/copy', $invoice) }}">
            @csrf
            <x-error></x-error>
            <div class="col-md-6">
                <div class="card card-body">
                    <h5>Client: {{ $invoice->client->name }}</h5>
                    <h5>Total: {{ $invoice->total_formatted }}</h5>
                    <h5>Status: {{ $invoice->invoiceStatus->name }}</h5>
                    <h5>Date Sent: {{ $invoice->date_sent }}</h5>
                    <h5>Date Paid: {{ $invoice->date_paid }}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-body">
                    <h5>Number of Items: {{ $invoice->invoiceItems->count() }}</h5>
                    <h5>Number of Payments: {{ $invoice->invoicePayments->count() }}</h5>
                </div>
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Copy Invoice
                    <i class="fas fa-copy ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
