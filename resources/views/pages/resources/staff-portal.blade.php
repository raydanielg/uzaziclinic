@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Staff Portal</h1>
                    <p class="text-muted mb-0">Secure access for clinic staff to manage schedules, records, and daily operations.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Who is this for?</h5>
                                <p class="text-muted mb-0">Doctors, nurses, pharmacists, lab technicians, receptionists, and administrators with authorized accounts.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Security</h5>
                                <p class="text-muted mb-0">Do not share passwords. Use strong credentials and sign out on shared computers to protect patient privacy.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Access Options</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <a class="text-decoration-none" href="{{ route('login') }}">
                                            <div class="p-3 rounded-4 h-100" style="border: 1px solid rgba(22,163,74,0.20); background: rgba(22,163,74,0.06);">
                                                <div class="fw-bold text-dark">Login</div>
                                                <div class="text-muted small">Sign in to continue</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="text-decoration-none" href="{{ route('register') }}">
                                            <div class="p-3 rounded-4 h-100" style="border: 1px solid rgba(22,163,74,0.20); background: rgba(22,163,74,0.06);">
                                                <div class="fw-bold text-dark">Create Account</div>
                                                <div class="text-muted small">Request staff access</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="text-decoration-none" href="{{ route('support.contact-support') }}">
                                            <div class="p-3 rounded-4 h-100" style="border: 1px solid rgba(22,163,74,0.20); background: rgba(22,163,74,0.06);">
                                                <div class="fw-bold text-dark">Contact Support</div>
                                                <div class="text-muted small">Need help signing in?</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <p class="text-muted mb-0">If you are a staff member and you cannot access your account, contact support to confirm your role and permissions.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
