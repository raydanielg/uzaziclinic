@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Research</h1>
                    <p class="text-muted mb-0">Clinical research highlights and educational content to support better health outcomes.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Evidence-Based Care</h5>
                                <p class="text-muted mb-0">We encourage practices based on credible research to improve patient safety, quality, and outcomes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Data Privacy & Ethics</h5>
                                <p class="text-muted mb-0">Patient confidentiality, consent, and ethical review are core principles for any clinical study.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Research Topics</h5>
                                <p class="text-muted mb-3">Examples of topics we may publish educational summaries about:</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08);">
                                            <div class="fw-bold">Maternal Health</div>
                                            <div class="text-muted small">Prenatal care, postnatal care, prevention</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08);">
                                            <div class="fw-bold">Chronic Conditions</div>
                                            <div class="text-muted small">Diabetes, hypertension, long-term care</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded-4" style="background: rgba(22,163,74,0.08);">
                                            <div class="fw-bold">Preventive Screening</div>
                                            <div class="text-muted small">Early detection, routine check-ups</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex flex-column flex-sm-row gap-2">
                                    <a href="{{ route('resources.guidelines') }}" class="btn btn-outline-success fw-bold rounded-3 px-4 py-2">View Guidelines</a>
                                    <a href="{{ route('resources.health-tips') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">Health Tips</a>
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
