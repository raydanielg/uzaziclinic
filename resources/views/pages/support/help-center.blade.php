@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Help Center</h1>
                    <p class="text-muted mb-0">Find answers, learn how to use our services, and get support fast.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Appointments & Scheduling</h5>
                                <p class="text-muted mb-3">Everything you need to book, reschedule, or cancel an appointment with confidence.</p>
                                <ul class="text-muted mb-0">
                                    <li>How to request an appointment</li>
                                    <li>How to change appointment details</li>
                                    <li>Late arrival and cancellation policy</li>
                                    <li>Emergency vs routine visits</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Account & Login</h5>
                                <p class="text-muted mb-3">Trouble signing in? Need to update your profile or password? Start here.</p>
                                <ul class="text-muted mb-0">
                                    <li>Resetting your password</li>
                                    <li>Verifying your email address</li>
                                    <li>Keeping your account secure</li>
                                    <li>Managing notifications</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Medical Records</h5>
                                <p class="text-muted mb-3">Learn how records are stored, accessed, and protected, and what you can view.</p>
                                <ul class="text-muted mb-0">
                                    <li>What appears in your history</li>
                                    <li>Sharing records with a clinician</li>
                                    <li>Privacy and data protection</li>
                                    <li>Requesting corrections</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Payments & Billing</h5>
                                <p class="text-muted mb-3">Guidance for payments, receipts, and billing support for clinic services.</p>
                                <ul class="text-muted mb-0">
                                    <li>Accepted payment methods</li>
                                    <li>Getting a receipt or invoice</li>
                                    <li>Insurance basics</li>
                                    <li>Billing support contacts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.25s;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Still need help?</h5>
                                <p class="text-muted mb-0">If you can’t find what you need, contact our support team and we’ll assist you.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('support.contact-support') }}" class="btn btn-success px-4 py-2 fw-bold rounded-3">
                                    Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
