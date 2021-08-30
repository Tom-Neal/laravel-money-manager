@extends('layouts.app')
@section('page-title', $invoice->number)
@section('content')
    @livewire('invoice-page', [
            'invoice' => $invoice
        ]
    )
    @push('css')
        @livewireStyles
    @endpush
    @push('js')
        <script src="{{ asset('js/alpine-2.8.2/alpine.js') }}" defer></script>
        @livewireScripts
    @endpush
@endsection
