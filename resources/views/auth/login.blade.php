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
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
                </div>

                @error('email')
                    <span class="invalid-feedback d-block animate__animated animate__shakeX" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-1"></i><strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                </div>

                @error('password')
                    <span class="invalid-feedback d-block animate__animated animate__shakeX" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-1"></i><strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-row mb-4">
                <div class="form-check custom-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="auth-link animated-link" href="{{ route('password.request') }}">
                        <i class="fa-solid fa-key me-1"></i>{{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="btn auth-btn" id="submitBtn">
                <span class="spinner"></span>
                <span class="btn-text">{{ __('Login') }}</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.auth-form');
        const btn = document.getElementById('submitBtn');
        
        if (form && btn) {
            form.addEventListener('submit', function() {
                btn.classList.add('loading');
                btn.disabled = true;
            });
        }
    });
</script>
@endsection
