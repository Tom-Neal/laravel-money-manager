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
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <h3>All Invoices</h3>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="table_center table_col_width_10">Number</th>
                                <th>Total</th>
                                <th class="table_center">Date Sent</th>
                                <th class="table_col_width_20">Type</th>
                                <th class="table_col_width_20">Client/Business</th>
                                <th class="table_center table_col_width_15">Status</th>
                                <th class="table_center table_col_width_5">PDF</th>
                                <th class="table_center table_col_width_5">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="table_center">{{ $invoice->number }}</td>
                                    <td>{{ $invoice->total_formatted }}</td>
                                    <td class="table_center">
                                        @if($invoice->date_sent) {{ date('d/m/Y', strtotime($invoice->date_sent)) }} @else - @endif
                                    </td>
                                    <td>{{ $invoice->client->clientType->name }}</td>
                                    <td>
                                        {{ $invoice->client->name ?? $invoice->business->name ?? '' }}
                                    </td>
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
                                        <a class="btn btn-warning btn-sm" href="{{ url('invoices/edit', $invoice) }}">
                                            <i class="fas fa-wrench text-white" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
