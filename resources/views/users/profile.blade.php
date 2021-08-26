@extends('layouts.app')
@section('page-title', 'Update Profile')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row">
        <div class="col-md-12">
            <h1>User Profile</h1>
            <p>
                Email and password change
            </p>
        </div>
    </div>
    <div class="card card-body p-4 mb-3">
        <form class="row" method="POST" action="{{ url('users/profile', auth()->user()->id) }}">
            @method('PATCH')
            @csrf
            <x-error></x-error>
            <div class="mb-3 col-md-12">
                <label class="control-label" for="email">Email</label>
                <input id="email" class="form-control" name="email" value="{{ auth()->user()->email }}" type="email" required />
            </div>
            <div class="mb-3 col-md-6">
                <label class="control-label" for="password">Password</label>
                <input id="password" class="form-control" name="password" type="password" autocomplete="off" required />
            </div>
            <div class="mb-3 col-md-6">
                <label class="control-label" for="password_confirmation">Confirm Password</label>
                <input id="password-confirm" class="form-control" name="password_confirmation" type="password" autocomplete="off" required />
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Update Profile
                    <i class="fas fa-wrench ms-1"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="card card-body p-4">
        <form class="row" method="POST" action="{{ url('user/two-factor-authentication') }}">
            @if(auth()->user()->two_factor_secret)
                @method('DELETE')
            @endif
            @csrf
            <div class="mb-3 col-md-12">
                @if(auth()->user()->two_factor_secret)
                    <div class="alert alert-success">2FA is currently enabled on your account</div>
                @else
                    <div class="alert alert-danger">2FA is not currently enabled on your account</div>
                    <p class="mb-0">
                        Two Factor Authentication can be enabled on your account.
                        When enabled, you will be presented with a QR code to scan with your mobile.
                        We recommend using
                        <a class="text-info" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">
                            Google Authenticator
                        </a>
                        or
                        <a class="text-info" href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">
                            Microsoft Authenticator
                        </a>
                        for this. Future logins to the system will require the code generated from your
                        mobile's authenticator app, after providing your email and password.
                    </p>
                @endif
            </div>
            <div class="mb-3 col-md-12 d-grid gap-2 d-md-block text-end">
                <button type="submit" class="btn btn-primary">
                    @if(auth()->user()->two_factor_secret)
                        Remove 2FA
                        <i class="fas fa-times ms-1" aria-hidden="true"></i>
                    @else
                        Add 2FA
                        <i class="fas fa-check ms-1" aria-hidden="true"></i>
                    @endif
                </button>
            </div>
        </form>
        <div class="row">
            @if(session('status') == 'two-factor-authentication-enabled')
                <div class="mb-3 col-md-6">
                    <p class="mb-3 font-medium text-sm text-green-600">
                        Two factor authentication has been enabled - please scan this
                        QR code into your phone authenticator application (please do this now
                        before leaving the page):
                    </p>
                    <span class="mb-3">{!! auth()->user()->twoFactorQrCodeSvg() !!}</span>
                </div>
                <div class="mb-3 col-md-6">
                    <p class="mb-3">
                        These recovery codes are required in the event of you not being able use 2FA.
                        Please store these codes in a secure location:
                    </p>
                    @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes, true)) as $code)
                        @if($loop->index < 2)
                            <span class="fw-bold">{{ trim($code) }}</span><br />
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
