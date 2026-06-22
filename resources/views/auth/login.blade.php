@extends('layouts.app')

@section('content')
<style>
    .salamapay-login {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background-image:
            linear-gradient(rgba(2, 73, 56, 0.88), rgba(1, 48, 40, 0.92)),
            url('{{ asset('bg-auth.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    .salamapay-login::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
        background-size: 24px 24px;
        pointer-events: none;
        z-index: 0;
    }
    @keyframes simpleFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .sp-fade-in {
        animation: simpleFadeIn 0.8s ease-out both;
    }
    .sp-card {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    .sp-header {
        background: linear-gradient(135deg, #059669, #047857);
        padding: 2.5rem 2rem 2rem;
        text-align: center;
    }
    .sp-icon-box {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        background: rgba(255,255,255,0.12);
        -webkit-backdrop-filter: blur(4px);
        backdrop-filter: blur(4px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sp-icon-box img {
        width: 36px;
        height: 36px;
        object-fit: contain;
    }
    .sp-header h2 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
    }
    .sp-header p {
        color: rgba(255,255,255,0.85);
        font-size: 0.875rem;
        margin: 0.35rem 0 0;
    }
    .sp-body {
        padding: 2rem;
    }
    .sp-input-wrap {
        position: relative;
    }
    .sp-input-wrap .sp-input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
        z-index: 2;
    }
    .sp-input {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s;
        background: #fff;
    }
    .sp-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }
    .sp-input.is-invalid {
        border-color: #fca5a5;
        box-shadow: 0 0 0 3px rgba(252, 165, 165, 0.2);
    }
    .sp-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }
    .sp-error {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: #dc2626;
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }
    .sp-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 1.25rem 0;
    }
    .sp-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }
    .sp-check input {
        width: 1rem;
        height: 1rem;
        accent-color: #059669;
        cursor: pointer;
    }
    .sp-link {
        font-size: 0.875rem;
        font-weight: 600;
        color: #059669;
        text-decoration: none;
        transition: color 0.2s;
    }
    .sp-link:hover {
        color: #047857;
        text-decoration: underline;
    }
    .sp-btn {
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 10px;
        border: none;
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
        color: #1f2937;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.35);
    }
    .sp-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(251, 191, 36, 0.45);
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    .sp-btn:disabled {
        opacity: 0.8;
        cursor: not-allowed;
        transform: none;
    }
    .sp-btn .spinner {
        display: none;
        width: 1.1rem;
        height: 1.1rem;
        border: 2px solid rgba(31, 41, 55, 0.3);
        border-radius: 50%;
        border-top-color: #1f2937;
        animation: spin 0.8s linear infinite;
    }
    .sp-btn.loading .spinner {
        display: inline-block;
    }
    .sp-btn.loading .btn-text {
        opacity: 0.9;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .sp-copyright {
        text-align: center;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
        margin-top: 1.5rem;
        position: relative;
        z-index: 1;
    }
</style>

<div class="salamapay-login">
    <div class="sp-card sp-fade-in">
        <div class="sp-header">
            <div class="sp-icon-box">
                <img src="{{ asset('login-icon.png') }}" alt="Login">
            </div>
            <h2>Welcome Back</h2>
            <p>Sign in to your account</p>
        </div>

        <div class="sp-body">
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="email" class="sp-label">Email Address</label>
                    <div class="sp-input-wrap">
                        <span class="sp-input-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            class="sp-input @error('email') is-invalid @enderror" placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="sp-error">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="sp-label">Password</label>
                    <div class="sp-input-wrap">
                        <span class="sp-input-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="sp-input @error('password') is-invalid @enderror" placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="sp-error">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="sp-row">
                    <label class="sp-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="sp-link">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="sp-btn" id="submitBtn">
                    <span class="spinner"></span>
                    <span class="btn-text">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Sign In
                    </span>
                </button>
            </form>
        </div>
    </div>

    <p class="sp-copyright">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
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

        // Custom login alerts
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid email or password. Please check your credentials and try again.',
                confirmButtonColor: '#166534',
                confirmButtonText: 'Try Again',
                backdrop: 'rgba(0,0,0,0.5)',
                allowOutsideClick: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: "{{ session('error') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'OK',
                backdrop: 'rgba(0,0,0,0.5)',
                allowOutsideClick: false
            });
        @endif

        @if (session('restricted'))
            Swal.fire({
                icon: 'warning',
                title: 'Account Restricted',
                text: "{{ session('restricted') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Understood',
                backdrop: 'rgba(0,0,0,0.5)',
                allowOutsideClick: false
            });
        @endif

        @if (session('blocked'))
            Swal.fire({
                icon: 'error',
                title: 'Account Blocked',
                text: "{{ session('blocked') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Contact Support',
                backdrop: 'rgba(0,0,0,0.5)',
                allowOutsideClick: false
            });
        @endif

        @if (session('banned'))
            Swal.fire({
                icon: 'error',
                title: 'Account Banned',
                text: "{{ session('banned') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'OK',
                backdrop: 'rgba(0,0,0,0.5)',
                allowOutsideClick: false
            });
        @endif

        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('status') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Continue',
                backdrop: 'rgba(0,0,0,0.5)'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Great',
                backdrop: 'rgba(0,0,0,0.5)'
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Heads Up',
                text: "{{ session('info') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Got it',
                backdrop: 'rgba(0,0,0,0.5)'
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#166534',
                confirmButtonText: 'Understood',
                backdrop: 'rgba(0,0,0,0.5)'
            });
        @endif
    });
</script>
@endsection
