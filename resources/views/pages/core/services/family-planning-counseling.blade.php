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
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Family Planning Counseling</li>
                    </ol>
                </nav>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-8 animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: rgba(22,163,74,0.10);">
                                    <i class="fas fa-hand-holding-heart fs-3" style="color:#16a34a;"></i>
                                </div>
                                <h1 class="fw-bold mb-0">Family Planning Counseling</h1>
                            </div>
                            <p class="text-muted lead">Expert guidance on contraceptive methods and family planning options tailored to your reproductive goals and health needs.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p class="text-muted">At UzaziClinic, our family planning counseling services are designed to help you make informed decisions about your reproductive health. Our specialized counselors provide comprehensive, confidential, and non-judgmental guidance on all aspects of family planning.</p>
                                <p class="text-muted">We believe that every individual and couple has the right to choose if, when, and how many children to have. Our role is to provide you with accurate, evidence-based information so you can make the choice that is right for you.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">What We Offer</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Comprehensive contraceptive method counseling including hormonal and non-hormonal options</li>
                                    <li class="mb-2">Fertility awareness and natural family planning education</li>
                                    <li class="mb-2">Pre-conception counseling and health optimization</li>
                                    <li class="mb-2">Postpartum family planning guidance</li>
                                    <li class="mb-2">Emergency contraceptive information and access</li>
                                    <li class="mb-2">Counseling on sterilization options and alternatives</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Our Approach</h5>
                                <p class="text-muted">We take a patient-centered approach to family planning counseling. Each session begins with understanding your unique situation, preferences, and health history. Our counselors take the time to explain all available options, including their benefits, risks, and effectiveness rates.</p>
                                <p class="text-muted mb-0">We respect your autonomy and support your right to make your own reproductive health decisions. All counseling sessions are completely confidential, and you will never be pressured into any method or decision.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Who Should Visit</h5>
                                <p class="text-muted">Our family planning counseling services are for:</p>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Individuals and couples exploring contraceptive options</li>
                                    <li class="mb-2">Those planning to start or expand their family</li>
                                    <li class="mb-2">Individuals seeking fertility awareness education</li>
                                    <li class="mb-2">Postpartum mothers needing family planning guidance</li>
                                    <li class="mb-2">Anyone with questions about reproductive health and family planning</li>
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
                                        <div class="text-muted small">30-45 minutes per session</div>
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
                                <p class="text-muted small mb-3">Schedule a confidential family planning counseling session today.</p>
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Related Services</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ url('/services/maternal-health') }}" class="text-decoration-none small">Maternal & Reproductive Health</a></li>
                                    <li class="mb-2"><a href="{{ url('/services/health-education') }}" class="text-decoration-none small">Reproductive Health Education</a></li>
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