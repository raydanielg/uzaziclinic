@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">About Us</h1>
                    <p class="text-muted mb-0">UzaziClinic is a specialized reproductive health and family planning clinic dedicated to providing comprehensive, confidential, and compassionate care for all your reproductive health needs.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Our Mission</h5>
                                <p class="text-muted mb-0">To provide accessible, confidential, and quality reproductive health and family planning services that empower individuals and families to make informed decisions about their reproductive health and family size.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Our Vision</h5>
                                <p class="text-muted mb-0">To be the leading reproductive health and family planning clinic in Tanzania, known for excellence in patient care, confidentiality, and empowering individuals to achieve their desired family size through informed choices.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08); border: 1px solid rgba(22,163,74,0.15);">
                                            <div class="fw-bold mb-1">Confidential Care</div>
                                            <div class="text-muted small">We ensure complete privacy and confidentiality for all reproductive health services.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08); border: 1px solid rgba(22,163,74,0.15);">
                                            <div class="fw-bold mb-1">Expert Team</div>
                                            <div class="text-muted small">Specialized healthcare professionals in reproductive health and family planning.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08); border: 1px solid rgba(22,163,74,0.15);">
                                            <div class="fw-bold mb-1">Comprehensive Services</div>
                                            <div class="text-muted small">Full range of family planning methods and reproductive health support.</div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4" style="opacity: 0.08;">

                                <h5 class="fw-bold mb-2">What we offer</h5>
                                <p class="text-muted mb-3">Our specialized reproductive health and family planning services are designed to support you at every stage of your reproductive journey with dignity and respect.</p>
                                <ul class="text-muted mb-0">
                                    <li><a href="{{ url('/services/family-planning-counseling') }}" class="text-decoration-none">Family planning counseling and contraceptive methods</a></li>
                                    <li><a href="{{ url('/services/maternal-health') }}" class="text-decoration-none">Maternal and reproductive health consultations</a></li>
                                    <li><a href="{{ url('/services/pregnancy-care') }}" class="text-decoration-none">Pregnancy testing and prenatal care support</a></li>
                                    <li><a href="{{ url('/services/health-education') }}" class="text-decoration-none">Reproductive health education and counseling</a></li>
                                    <li><a href="{{ url('/services/confidential-counseling') }}" class="text-decoration-none">Confidential counseling and follow-up support</a></li>
                                </ul>

                                <div class="mt-4 d-flex flex-column flex-sm-row gap-2">
                                    <a href="{{ route('services') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">View Services</a>
                                    <a href="{{ route('contact') }}" class="btn btn-outline-success fw-bold rounded-3 px-4 py-2">Contact Us</a>
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
