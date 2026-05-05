@extends('layouts.app')

@section('content')
<div class="auth-page" style="--auth-bg: url('{{ asset('Untitled design (2).png') }}');">
    <div class="auth-card animate__animated animate__fadeInDown">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </div>
        </div>

        <div class="auth-title mb-3">{{ __('Register') }}</div>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-user"></i></span>
                    <input id="name" type="text" class="form-control auth-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                </div>
                @error('name')
                    <span class="invalid-feedback d-block animate__animated animate__shakeX" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                </div>
                @error('email')
                    <span class="invalid-feedback d-block animate__animated animate__shakeX" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                </div>
                @error('password')
                    <span class="invalid-feedback d-block animate__animated animate__shakeX" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input id="password-confirm" type="password" class="form-control auth-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                </div>
            </div>

            <button type="submit" class="btn auth-btn" id="submitBtn">
                <span class="spinner"></span>
                <span class="btn-text">{{ __('Register') }}</span>
            </button>

            <div class="auth-footer mt-4 text-center">
                <p class="text-muted">Already have an account? 
                    <a href="{{ route('login') }}" class="auth-link animated-link font-weight-bold">
                        <i class="fa-solid fa-sign-in me-1"></i>{{ __('Login') }}
                    </a>
                </p>
            </div>
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
