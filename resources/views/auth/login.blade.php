@extends('layouts.app')

@section('content')
<div class="auth-page" style="--auth-bg: url('{{ asset('african-american-young-patient-with-protective-face-mask-against-covid-resting-bed_482257-26825.jpg') }}');">
    <div class="auth-card animate__animated animate__fadeInDown">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                @endif
            </div>

            <button type="submit" class="btn auth-btn">
                {{ __('Login') }}
            </button>
        </form>
    </div>
</div>
@endsection
