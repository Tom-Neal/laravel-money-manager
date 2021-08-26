<link href="{{ asset('css/bootstrap-5.0.0/bootstrap.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Changa+One&family=Nunito&display=swap" rel="stylesheet">
@if(auth()->user())
    <link href="{{ asset('css/flatpickr-4.6.3/flatpickr.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/fontawesome-5.14.0/css/all.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/sweetalert/sweetalert.css') }}" rel="stylesheet" />
    @stack('css')
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet" />
@else
    <link href="{{ asset(mix('css/login.css')) }}" rel="stylesheet" />
@endif
