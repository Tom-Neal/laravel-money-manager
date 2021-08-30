@extends('layouts.app')
@section('page-title', $client->name)
@section('content')
    @livewire('client-show-page', [
        'client' => $client
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
