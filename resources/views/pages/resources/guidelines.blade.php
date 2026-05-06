@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Guidelines</h1>
                    <p class="text-muted mb-0">Simple and clear clinic guidelines to help you get the best care experience.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Before Your Visit</h5>
                                <p class="text-muted mb-3">Prepare to save time and ensure the doctor has accurate information.</p>
                                <ul class="text-muted mb-0">
                                    <li>Bring a valid ID and any previous medical documents</li>
                                    <li>List medications you are currently using</li>
                                    <li>Arrive 10–15 minutes early for registration</li>
                                    <li>Notify us early if you need to reschedule</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">During Your Visit</h5>
                                <p class="text-muted mb-3">Help us provide safe and efficient service for everyone.</p>
                                <ul class="text-muted mb-0">
                                    <li>Follow staff instructions and clinic flow</li>
                                    <li>Keep personal items secure at all times</li>
                                    <li>Respect privacy of other patients</li>
                                    <li>Ask questions if anything is unclear</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Safety & Hygiene</h5>
                                <p class="text-muted mb-3">We maintain a clean environment—your cooperation matters.</p>
                                <ul class="text-muted mb-0">
                                    <li>Use hand sanitizer when entering the clinic</li>
                                    <li>Wear a mask if you have flu-like symptoms</li>
                                    <li>Report any allergic reactions immediately</li>
                                    <li>Follow infection prevention guidance when advised</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">After Your Visit</h5>
                                <p class="text-muted mb-3">Next steps to support recovery and continuity of care.</p>
                                <ul class="text-muted mb-0">
                                    <li>Follow prescribed medication instructions</li>
                                    <li>Book follow-up visits if required</li>
                                    <li>Contact support if symptoms worsen</li>
                                    <li>Keep your medical documents safe</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.25s;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-2">Need more help?</h5>
                        <p class="text-muted mb-0">Visit the FAQs or contact support for assistance.</p>
                        <div class="mt-3 d-flex flex-column flex-sm-row gap-2">
                            <a href="{{ route('support.faqs') }}" class="btn btn-outline-success fw-bold rounded-3 px-4 py-2">View FAQs</a>
                            <a href="{{ route('support.contact-support') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">Contact Support</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
