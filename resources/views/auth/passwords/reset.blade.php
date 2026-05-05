@extends('layouts.app')

@section('content')
<div class="auth-page" style="--auth-bg: url('{{ asset('Untitled design (2).png') }}');">
    <div class="auth-card animate__animated animate__fadeInDown">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </div>
        </div>

        <div class="auth-title mb-3">{{ __('Reset Password') }}</div>

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text auth-input-icon"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
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
                    <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New password">
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
                    <input id="password-confirm" type="password" class="form-control auth-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password">
                </div>
            </div>

            <button type="submit" class="btn auth-btn" id="submitBtn">
                <span class="spinner"></span>
                <span class="btn-text">{{ __('Reset Password') }}</span>
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
