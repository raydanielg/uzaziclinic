@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Contact Support</h1>
                    <p class="text-muted mb-0">We’re here to help. Choose the best support option for your issue.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-envelope" style="color:#16a34a;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Email Support</h5>
                                </div>
                                <p class="text-muted mb-3">For account issues, record questions, and general inquiries.</p>
                                <p class="mb-0"><span class="fw-semibold">Email:</span> <span class="text-muted">info@uzaziclinic.com</span></p>
                                <p class="mb-0"><span class="fw-semibold">Response time:</span> <span class="text-muted">Within 24 hours</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-phone" style="color:#16a34a;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Phone</h5>
                                </div>
                                <p class="text-muted mb-3">For urgent assistance during working hours.</p>
                                <p class="mb-0"><span class="fw-semibold">Phone:</span> <span class="text-muted">+255 700 000 000</span></p>
                                <p class="mb-0"><span class="fw-semibold">Hours:</span> <span class="text-muted">Mon–Sat, 8:00–18:00</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-comments" style="color:#16a34a;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Help Articles</h5>
                                </div>
                                <p class="text-muted mb-3">Self-service guides for common problems and requests.</p>
                                <a href="{{ route('support.help-center') }}" class="btn btn-success w-100 fw-bold rounded-3 py-2">Go to Help Center</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-2">Send a Support Request</h5>
                        <p class="text-muted mb-4">If your issue is sensitive, include only necessary details. Do not share passwords.</p>

                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" class="form-control" placeholder="Your name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" placeholder="you@example.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Topic</label>
                                    <select class="form-select">
                                        <option selected>Choose a topic</option>
                                        <option>Login / Account</option>
                                        <option>Appointments</option>
                                        <option>Medical Records</option>
                                        <option>Billing</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message</label>
                                    <textarea class="form-control" rows="5" placeholder="Describe your issue in detail"></textarea>
                                </div>
                                <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                                    <p class="text-muted mb-0 small">By submitting, you agree that we may contact you regarding your request.</p>
                                    <button type="button" class="btn btn-success px-4 py-2 fw-bold rounded-3">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
