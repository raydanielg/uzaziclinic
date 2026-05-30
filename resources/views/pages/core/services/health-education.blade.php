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
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Reproductive Health Education</li>
                    </ol>
                </nav>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-8 animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: rgba(22,163,74,0.10);">
                                    <i class="fas fa-book-open fs-3" style="color:#16a34a;"></i>
                                </div>
                                <h1 class="fw-bold mb-0">Reproductive Health Education</h1>
                            </div>
                            <p class="text-muted lead">Empowering individuals and couples with knowledge about reproductive health, fertility, and informed family planning decisions.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p class="text-muted">UzaziClinic is committed to empowering our community through comprehensive reproductive health education. We believe that informed individuals make better health decisions for themselves and their families. Our education programs are designed to provide accurate, evidence-based information in an accessible and supportive environment.</p>
                                <p class="text-muted">Our educational services cover a wide range of topics related to reproductive health, family planning, and overall wellness, tailored to different age groups and life stages.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Topics We Cover</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Understanding reproductive anatomy and physiology</li>
                                    <li class="mb-2">Fertility awareness and menstrual cycle education</li>
                                    <li class="mb-2">Contraceptive methods: how they work and how to choose</li>
                                    <li class="mb-2">Sexual health and STI prevention</li>
                                    <li class="mb-2">Preconception health and fertility optimization</li>
                                    <li class="mb-2">Pregnancy, childbirth, and postpartum education</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Our Approach</h5>
                                <p class="text-muted">Our educational sessions are interactive, engaging, and tailored to your learning needs. We offer both individual counseling sessions and group education programs. Our educators are experienced healthcare professionals who create a safe, non-judgmental space for asking questions and exploring topics.</p>
                                <p class="text-muted mb-0">We use visual aids, models, and take-home materials to enhance understanding and ensure you leave with practical knowledge you can apply to your reproductive health journey.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Who Should Attend</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Adolescents and young adults seeking reproductive health knowledge</li>
                                    <li class="mb-2">Couples preparing for pregnancy or family planning</li>
                                    <li class="mb-2">Individuals wanting to understand their fertility better</li>
                                    <li class="mb-2">Parents seeking age-appropriate reproductive health education for their children</li>
                                    <li class="mb-2">Community groups and organizations</li>
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
                                        <div class="text-muted small">45-60 minutes per session</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-user-md text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Provider</div>
                                        <div class="text-muted small">Health Education Specialist</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-users text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Format</div>
                                        <div class="text-muted small">Individual or group sessions</div>
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
                                <h6 class="fw-bold mb-2">Ready to learn?</h6>
                                <p class="text-muted small mb-3">Book an educational session to empower yourself with reproductive health knowledge.</p>
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Related Services</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ url('/services/family-planning-counseling') }}" class="text-decoration-none small">Family Planning Counseling</a></li>
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