@extends('layouts.app')
@section('page-title', 'Statements')
@section('content')
    @livewire('statement-page')
    @push('css')
        @livewireStyles
    @endpush
    @push('js')
        <script src="{{ asset('js/alpine-2.8.2/alpine.js') }}" defer></script>
        @livewireScripts
    @endpush
@endsection
