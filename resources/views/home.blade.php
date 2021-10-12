@extends('layouts.app')
@section('page-title', 'Home')
@section('content')
<div id="page" class="container">
    @if($clientTypes->isNotEmpty())
        <div class="row mb-3">
            @foreach($clientTypes as $clientType)
                <div class="col-lg-6">
                    <a class="btn btn-primary w-100 py-3 mb-3" href="{{ url('client-types/show', $clientType) }}">
                        {{ $clientType->name }} Clients
                        <i class="fas {{ $clientType->icon }} ms-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    @if($invoiceItemsRenewalRequired->isNotEmpty())
        <div class="card card-body mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Upcoming Renewals</h3>
                </div>
                <div class="col-lg-12">
                    @foreach($invoiceItemsRenewalRequired as $invoiceItem)
                        <div class="d-flex justify-content-between border-top py-2">
                            <div>{{ $invoiceItem->description }}</div>
                            <div class="d-flex align-items-center">
                                <div>{{ date('d/m/Y', strtotime($invoiceItem->renewal_required)) }}</div>
                                <a class="btn btn-outline-primary btn-sm ms-2" href="{{ url('clients/show', $invoiceItem->invoice->client) }}">
                                    View Client
                                    <i class="fas fa-eye ms-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if($recentInvoices->isNotEmpty())
        <div class="card card-body mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Recent Invoices</h3>
                </div>
                @foreach($recentInvoices as $recentInvoice)
                    <div class="col-lg-3 mb-2">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="text-start">
                                    {{ $recentInvoice->client->name }}<br />
                                    {{ $recentInvoice->total_formatted }}<br />
                                    {{ $recentInvoice->invoiceStatus->name }}
                                </div>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="{{ url('invoices/download', $recentInvoice) }}">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        Download
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('invoices/edit', $recentInvoice) }}">
                                        <i class="fas fa-wrench me-1"></i>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('clients/show', $recentInvoice->client_id) }}">
                                        <i class="fas fa-user me-1"></i>
                                        Client
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-lg-12">
                <h3>Income</h3>
            </div>
            <div class="col-lg-12">
                @foreach($invoiceYears as $key=>$invoices)
                    <div class="d-flex justify-content-between border-top py-2">
                        <div>{{ $key }}</div>
                        <div>
                            {{ CurrencyHelper::getFormattedValue($invoices->sum('total')) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-lg-12">
                <h3>Expenses</h3>
            </div>
            <div class="col-lg-12">
                @foreach($expenseYears as $key=>$expenses)
                    <div class="d-flex justify-content-between border-top py-2">
                        <div>{{ $key }}</div>
                        <div>
                            {{ CurrencyHelper::getFormattedValue($expenses->sum('price')) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
