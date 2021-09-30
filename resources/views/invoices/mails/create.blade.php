@extends('layouts.app')
@section('page-title', 'Send Invoice')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Send Invoice: {{ $invoice->number_formatted }}</h1>
            <p>Send invoice {{ $invoice->number_formatted }} to {{ $invoice->client->name }}.</p>
            @if($invoice->email_sent)
                <p class="mb-0 fw-bold text-danger fst-italic">Email was sent to client on {{ date('d/m/Y', strtotime($invoice->email_sent)) }}</p>
            @endif
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('invoices/download', $invoice) }}">
                Download
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body p-4 mb-3">
        <form class="row" method="POST" action="{{ url('invoices/mails', $invoice) }}">
            @csrf
            <x-error></x-error>
            <div class="mb-3 col-md-12">
                <label class="control-label" for="text">Message</label>
                <textarea class="form-control" name="text" rows="8" required></textarea>
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Send
                    <i class="fas fa-paper-plane ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
