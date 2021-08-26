<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}' }
        </script>
        <title>@yield('page-title') | {{ config('app.name') }}</title>
        <link href="{{ asset('images/favicon.ico') }}" rel="icon" type="image/ico" >
        @include('layouts.css')
    </head>
    <body>
        @include('layouts.page')
        @include('layouts.js')
    </body>
</html>
