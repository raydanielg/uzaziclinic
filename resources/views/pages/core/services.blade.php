@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Our Services</h1>
                    <p class="text-muted mb-0">Specialized reproductive health and family planning services — confidential, comprehensive, and designed for you.</p>
                </div>

                @php
                    $services = [
                        ['icon' => 'fa-hand-holding-heart', 'slug' => 'family-planning-counseling', 'title' => 'Family Planning Counseling', 'desc' => 'Expert guidance on contraceptive methods, fertility awareness, and family planning options tailored to your reproductive goals.'],
                        ['icon' => 'fa-person-pregnant', 'slug' => 'maternal-health', 'title' => 'Maternal & Reproductive Health', 'desc' => 'Comprehensive consultations for reproductive health concerns, preconception care, and maternal well-being.'],
                        ['icon' => 'fa-baby', 'slug' => 'pregnancy-care', 'title' => 'Pregnancy Testing & Prenatal Care', 'desc' => 'Reliable pregnancy testing services and thorough prenatal care support for a healthy pregnancy journey.'],
                        ['icon' => 'fa-book-open', 'slug' => 'health-education', 'title' => 'Reproductive Health Education', 'desc' => 'Empowering individuals and couples with knowledge about reproductive health, fertility, and informed family planning decisions.'],
                        ['icon' => 'fa-comments', 'slug' => 'confidential-counseling', 'title' => 'Confidential Counseling & Support', 'desc' => 'Private, non-judgmental counseling sessions addressing reproductive health concerns with complete confidentiality.'],
                    ];
                @endphp

                <div class="row g-4">
                    @foreach($services as $i => $service)
                        <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ 0.1 * ($i + 1) }}s;">
                            <a href="{{ url('/services/' . $service['slug']) }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                                    <div class="card-body p-4 p-md-5">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 46px; height: 46px; background: rgba(22,163,74,0.10);">
                                                <i class="fas {{ $service['icon'] }}" style="color:#16a34a;"></i>
                                            </div>
                                            <h5 class="fw-bold mb-0 text-dark">{{ $service['title'] }}</h5>
                                        </div>
                                        <p class="text-muted mb-0">{{ $service['desc'] }}</p>
                                        <span class="service-link fw-bold text-uppercase small mt-3 d-inline-flex align-items-center">
                                            Learn more <i class="fas fa-arrow-right ms-2"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.35s;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Ready to book a visit?</h5>
                                <p class="text-muted mb-0">Schedule an appointment and our team will guide you to the right service.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">Make Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .service-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    }
    .service-link {
        color: #16a34a;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
    }
</style>
@endsection
