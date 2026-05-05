@extends('layouts.app')

@section('content')
<div class="auth-page" style="--auth-bg: url('{{ asset('african-american-young-patient-with-protective-face-mask-against-covid-resting-bed_482257-26825.jpg') }}');">
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
            <button type="submit" class="btn auth-btn">
                {{ __('Resend Verification Email') }}
            </button>

            <div class="auth-footer">
                <a class="auth-link" href="{{ route('login') }}">{{ __('Back to Login') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
