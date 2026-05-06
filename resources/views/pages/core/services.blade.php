@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Services</h1>
                    <p class="text-muted mb-0">Comprehensive healthcare services designed for quality, safety, and convenience.</p>
                </div>

                @php
                    $services = [
                        ['icon' => 'fa-stethoscope', 'title' => 'General Consultation', 'desc' => 'Clinical assessment, diagnosis, and treatment plan with professional guidance.'],
                        ['icon' => 'fa-user-doctor', 'title' => 'Specialist Care', 'desc' => 'Access specialist services with proper referrals and coordinated care.'],
                        ['icon' => 'fa-flask', 'title' => 'Laboratory Testing', 'desc' => 'Reliable lab tests with clear results and clinical interpretation support.'],
                        ['icon' => 'fa-heart-pulse', 'title' => 'Emergency Support', 'desc' => 'Fast response for urgent cases and referrals to emergency care when needed.'],
                        ['icon' => 'fa-person-pregnant', 'title' => 'Maternal Health', 'desc' => 'Prenatal and postnatal support with safe monitoring and follow-up.'],
                        ['icon' => 'fa-syringe', 'title' => 'Vaccination', 'desc' => 'Preventive vaccines guidance and administration based on recommendations.'],
                        ['icon' => 'fa-pills', 'title' => 'Pharmacy & Prescriptions', 'desc' => 'Medication support, prescription guidance, and safe usage instructions.'],
                        ['icon' => 'fa-notes-medical', 'title' => 'Medical Records', 'desc' => 'Organized documentation to support continuity of care and follow-up visits.'],
                        ['icon' => 'fa-hand-holding-medical', 'title' => 'Health Counseling', 'desc' => 'Education and counseling to help patients manage health conditions better.'],
                    ];
                @endphp

                <div class="row g-4">
                    @foreach($services as $i => $service)
                        <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ 0.05 * ($i + 1) }}s;">
                            <div class="card border-0 shadow-sm rounded-4 h-100 service-card">
                                <div class="card-body p-4 p-md-5">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 46px; height: 46px; background: rgba(22,163,74,0.10);">
                                            <i class="fas {{ $service['icon'] }}" style="color:#16a34a;"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0">{{ $service['title'] }}</h5>
                                    </div>
                                    <p class="text-muted mb-0">{{ $service['desc'] }}</p>
                                </div>
                            </div>
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
</style>
@endsection
