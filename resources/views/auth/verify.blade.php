@extends('layouts.app')

@section('content')
<div class="auth-page" style="--auth-bg: url('{{ asset('Untitled design (2).png') }}');">
    <div class="auth-card animate__animated animate__fadeInDown">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
            </div>
        </div>

        <div class="auth-title">{{ __('Verify Your Email') }}</div>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="auth-text">
            {{ __('Before proceeding, please check your email for a verification link.') }}
        </div>

        <div class="auth-text mt-2">
            {{ __('If you did not receive the email, you can request another one below.') }}
        </div>

        <form method="POST" action="{{ route('verification.resend') }}" class="auth-form mt-3">
            @csrf
            <button type="submit" class="btn auth-btn" id="submitBtn">
                <span class="spinner"></span>
                <span class="btn-text">{{ __('Resend Verification Email') }}</span>
            </button>

            <div class="auth-footer">
                <a class="auth-link" href="{{ route('login') }}">{{ __('Back to Login') }}</a>
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
