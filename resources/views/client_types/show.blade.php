@extends('layouts.app')
@section('page-title', $clientType->name)
@section('content')
    @livewire('client-type-show-page', [
        'clientType' => $clientType
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
