@extends('layouts.app')
@section('page-title', 'Comments')
@section('content')
    @livewire('comment-index-page')
    @push('css')
        @livewireStyles
    @endpush
    @push('js')
        <script src="{{ asset('js/alpine-2.8.2/alpine.js') }}" defer></script>
        @livewireScripts
    @endpush
@endsection
