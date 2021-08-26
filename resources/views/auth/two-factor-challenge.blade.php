@extends('layouts.guest')
@section('page-title', '2FA Check')
@section('content')
<main class="form-login">
    <form class="mb-3 d-flex flex-column align-items-center" method="POST" action="{{ url('two-factor-challenge') }}">
        <input name="_token" value="{{ csrf_token() }}" type="hidden">
        <img class="mb-4" src="{{ asset('images/logo-transparent-reversed.png') }}" alt="IHF">
        <p>Enter your 2FA code:</p>
        <input class="mb-3 form-control" name="code" type="text" placeholder="Code" />
        <button class="mb-3 w-100 btn btn-lg btn-primary" type="submit">Continue</button>
    </form>
    <form class="mb-3 d-flex flex-column align-items-center" method="POST" action="{{ url('two-factor-challenge') }}">
        <input name="_token" value="{{ csrf_token() }}" type="hidden">
        <p>Alternatively, please enter a 2FA recovery code:</p>
        <input class="mb-3 form-control" name="recovery_code" type="text" placeholder="Recovery code" />
        <button class="w-100 btn btn-lg btn-primary" type="submit">Continue</button>
    </form>
</main>
@endsection
