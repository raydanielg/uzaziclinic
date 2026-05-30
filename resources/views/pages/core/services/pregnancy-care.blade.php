@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" class="mb-4 animate__animated animate__fadeInUp">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/services') }}" class="text-decoration-none text-muted">Services</a></li>
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Pregnancy Testing & Prenatal Care</li>
                    </ol>
                </nav>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-8 animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: rgba(22,163,74,0.10);">
                                    <i class="fas fa-baby fs-3" style="color:#16a34a;"></i>
                                </div>
                                <h1 class="fw-bold mb-0">Pregnancy Testing & Prenatal Care</h1>
                            </div>
                            <p class="text-muted lead">Reliable pregnancy testing services and thorough prenatal care support for a healthy pregnancy journey.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p class="text-muted">UzaziClinic offers confidential pregnancy testing and comprehensive prenatal care services. Whether you are confirming a pregnancy or seeking ongoing prenatal support, our team provides accurate, compassionate, and non-judgmental care every step of the way.</p>
                                <p class="text-muted">We understand that pregnancy can bring both joy and uncertainty. Our goal is to provide you with the information, support, and medical care you need to navigate this important time with confidence.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">What We Offer</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Confidential pregnancy testing with accurate results</li>
                                    <li class="mb-2">Early prenatal assessments and health screenings</li>
                                    <li class="mb-2">Nutritional guidance for a healthy pregnancy</li>
                                    <li class="mb-2">Prenatal vitamin and supplement recommendations</li>
                                    <li class="mb-2">Referrals for ultrasound and advanced prenatal testing</li>
                                    <li class="mb-2">Emotional support and pregnancy counseling</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Our Process</h5>
                                <p class="text-muted">Our pregnancy testing service is quick, confidential, and respectful. We use high-accuracy testing methods and provide immediate results. If you are pregnant, our team will discuss your options and help you plan your next steps, whether that includes prenatal care with us or a referral to another provider.</p>
                                <p class="text-muted mb-0">For those continuing their pregnancy, we offer ongoing prenatal care that includes regular check-ups, health monitoring, and education to support a healthy pregnancy and delivery.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Who Should Visit</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Individuals who suspect they may be pregnant</li>
                                    <li class="mb-2">Those seeking confirmation of a home pregnancy test</li>
                                    <li class="mb-2">Pregnant individuals seeking early prenatal care</li>
                                    <li class="mb-2">Anyone needing pregnancy-related information and support</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Quick Info</h6>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-clock text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Duration</div>
                                        <div class="text-muted small">15-30 minutes (testing)<br>30-45 minutes (prenatal)</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-user-md text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Provider</div>
                                        <div class="text-muted small">Reproductive Health Specialist</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-shield-alt text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Confidentiality</div>
                                        <div class="text-muted small">100% private and secure</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-map-pin text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Location</div>
                                        <div class="text-muted small">Mlimani City, Dar es Salaam</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: rgba(22,163,74,0.05); border: 1px solid rgba(22,163,74,0.15) !important;">
                            <div class="card-body p-4 text-center">
                                <h6 class="fw-bold mb-2">Ready to book?</h6>
                                <p class="text-muted small mb-3">Schedule a confidential pregnancy test or prenatal visit today.</p>
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Related Services</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ url('/services/maternal-health') }}" class="text-decoration-none small">Maternal & Reproductive Health</a></li>
                                    <li class="mb-2"><a href="{{ url('/services/confidential-counseling') }}" class="text-decoration-none small">Confidential Counseling & Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection