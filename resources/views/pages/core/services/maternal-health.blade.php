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
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Maternal & Reproductive Health</li>
                    </ol>
                </nav>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-8 animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: rgba(22,163,74,0.10);">
                                    <i class="fas fa-person-pregnant fs-3" style="color:#16a34a;"></i>
                                </div>
                                <h1 class="fw-bold mb-0">Maternal & Reproductive Health</h1>
                            </div>
                            <p class="text-muted lead">Comprehensive maternal care and reproductive health consultations from preconception to postpartum support.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p class="text-muted">UzaziClinic provides comprehensive maternal and reproductive health services designed to support women throughout their reproductive journey. Our team of specialized healthcare professionals is dedicated to ensuring the health and well-being of both mother and child.</p>
                                <p class="text-muted">From preconception counseling to postpartum care, we offer a continuum of services that address the unique health needs of women at every stage of life.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">What We Offer</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Preconception health assessments and counseling</li>
                                    <li class="mb-2">Reproductive health consultations and check-ups</li>
                                    <li class="mb-2">Menstrual health management and support</li>
                                    <li class="mb-2">Fertility evaluations and guidance</li>
                                    <li class="mb-2">Postnatal check-ups and recovery support</li>
                                    <li class="mb-2">Breastfeeding counseling and support</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Why Choose Us</h5>
                                <p class="text-muted">Our maternal and reproductive health services are delivered in a warm, supportive environment where your comfort and confidentiality are our top priorities. We take the time to listen to your concerns, answer your questions, and develop a care plan that respects your preferences and values.</p>
                                <p class="text-muted mb-0">Our team stays current with the latest evidence-based practices in maternal and reproductive health, ensuring you receive the highest standard of care.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Who Should Visit</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Women planning pregnancy or seeking preconception care</li>
                                    <li class="mb-2">Individuals with reproductive health concerns or questions</li>
                                    <li class="mb-2">Those experiencing menstrual irregularities or discomfort</li>
                                    <li class="mb-2">New mothers needing postnatal support</li>
                                    <li class="mb-2">Anyone seeking reproductive health education and guidance</li>
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
                                        <div class="text-muted small">30-60 minutes per visit</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-user-md text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Provider</div>
                                        <div class="text-muted small">Maternal Health Specialist</div>
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
                                <p class="text-muted small mb-3">Schedule a maternal or reproductive health consultation today.</p>
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Related Services</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ url('/services/pregnancy-care') }}" class="text-decoration-none small">Pregnancy Testing & Prenatal Care</a></li>
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