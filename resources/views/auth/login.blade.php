@extends('layouts.guest')
@section('page-title', 'Login')
@section('content')
<main class="form-login">
    <form class="d-flex flex-column align-items-center" method="POST" action="{{ route('login') }}">
        <h1 class="h3 mb-3 fw-bold">Login</h1>
        <input name="_token" value="{{ csrf_token() }}" type="hidden">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <label class="visually-hidden" for="email">Email address</label>
        <input id="email" class="form-control" name="email" type="email" placeholder="Email" required autofocus>
        @if($errors->has('email'))
            <span class="help-block mt-1 mb-1">{{ $errors->first('email') }}</span>
        @endif
        <label class="visually-hidden" for="password">Password</label>
        <input id="password" class="form-control" name="password" type="password" placeholder="Password" required>
        @if($errors->has('password'))
            <span class="help-block mt-1 mb-1">{{ $errors->first('password') }}</span>
        @endif
        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Sign In</button>
    </form>
</main>
@endsection
