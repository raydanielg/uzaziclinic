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
                        <li class="breadcrumb-item active fw-bold" aria-current="page">Confidential Counseling & Support</li>
                    </ol>
                </nav>

                <div class="row g-5 align-items-start">
                    <div class="col-lg-8 animate__animated animate__fadeInUp">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 56px; height: 56px; background: rgba(22,163,74,0.10);">
                                    <i class="fas fa-comments fs-3" style="color:#16a34a;"></i>
                                </div>
                                <h1 class="fw-bold mb-0">Confidential Counseling & Support</h1>
                            </div>
                            <p class="text-muted lead">Private, non-judgmental counseling sessions addressing reproductive health concerns with complete confidentiality.</p>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Overview</h5>
                                <p class="text-muted">UzaziClinic offers confidential counseling services for individuals and couples facing reproductive health concerns or decisions. Our trained counselors provide a safe, supportive, and private environment where you can discuss your concerns openly without fear of judgment.</p>
                                <p class="text-muted">Whether you are dealing with an unplanned pregnancy, facing fertility challenges, or simply need someone to talk to about reproductive health matters, we are here to listen and support you.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">What We Offer</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Private one-on-one counseling sessions</li>
                                    <li class="mb-2">Couples counseling for reproductive health decisions</li>
                                    <li class="mb-2">Support for unplanned pregnancy decisions</li>
                                    <li class="mb-2">Fertility-related emotional support</li>
                                    <li class="mb-2">Postpartum emotional wellness checks</li>
                                    <li class="mb-2">Referrals to specialized support services when needed</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Our Promise</h5>
                                <p class="text-muted">Your privacy is our utmost priority. All counseling sessions are conducted in private, soundproof rooms, and your records are kept strictly confidential. We will never share your information without your explicit written consent.</p>
                                <p class="text-muted">Our counselors are trained in reproductive health counseling and approach every session with empathy, respect, and cultural sensitivity. You will never be pressured into any decision — our role is to support you in making the choice that is right for you.</p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Who Should Visit</h5>
                                <ul class="text-muted mb-0">
                                    <li class="mb-2">Individuals facing unplanned pregnancy and needing support</li>
                                    <li class="mb-2">Couples navigating family planning decisions together</li>
                                    <li class="mb-2">Those experiencing fertility-related stress or anxiety</li>
                                    <li class="mb-2">Individuals with reproductive health concerns they wish to discuss privately</li>
                                    <li class="mb-2">Anyone needing emotional support related to reproductive health</li>
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
                                        <div class="text-muted small">Certified Reproductive Health Counselor</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 36px; height: 36px; background: rgba(22,163,74,0.10);">
                                        <i class="fas fa-shield-alt text-green-600 small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small">Confidentiality</div>
                                        <div class="text-muted small">Strictly private & confidential</div>
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
                                <h6 class="fw-bold mb-2">Need to talk?</h6>
                                <p class="text-muted small mb-3">Schedule a private, confidential counseling session today.</p>
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">Related Services</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ url('/services/family-planning-counseling') }}" class="text-decoration-none small">Family Planning Counseling</a></li>
                                    <li class="mb-2"><a href="{{ url('/services/pregnancy-care') }}" class="text-decoration-none small">Pregnancy Testing & Prenatal Care</a></li>
                                    <li class="mb-2"><a href="{{ url('/services/health-education') }}" class="text-decoration-none small">Reproductive Health Education</a></li>
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