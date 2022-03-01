@extends('layouts.app')
@section('page-title', $invoice->number)
@section('content')
    @livewire('invoice-page', [
            'invoice' => $invoice
        ]
    )
    @push('css')
        @livewireStyles
        <link href="{{ asset('css/trix-1.3.1/trix.css') }}" rel="stylesheet" />
    @endpush
    @push('js')
        <script src="{{ asset('js/alpine-2.8.2/alpine.js') }}" defer></script>
        @livewireScripts
        <script src="{{ asset('js/trix-1.3.1/trix.js') }}" defer></script>
        <script>
            function form() {
                return {
                    save() {
                        window.livewire.emit('updateClientDescription', {
                            client_description: this.$refs.client_description.value,
                        });
                    }
                }
            }
            // Does not hide attachment button but disables functionality
            document.addEventListener("trix-file-accept", function(event) {
                event.preventDefault();
            });
        </script>
    @endpush
@endsection
