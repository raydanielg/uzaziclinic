@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">News</h1>
                    <p class="text-muted mb-0">Clinic announcements, service updates, and health-related news.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill" style="background: rgba(22,163,74,0.12); color:#16a34a;">Announcement</span>
                                    <span class="text-muted small">Updated recently</span>
                                </div>
                                <h5 class="fw-bold mb-2">New Service Hours</h5>
                                <p class="text-muted mb-0">We have extended service hours for selected departments to help you access care more easily.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill" style="background: rgba(22,163,74,0.12); color:#16a34a;">Update</span>
                                    <span class="text-muted small">Platform</span>
                                </div>
                                <h5 class="fw-bold mb-2">Improved Appointment Booking</h5>
                                <p class="text-muted mb-0">We updated the booking flow to make scheduling and reminders faster and clearer.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill" style="background: rgba(22,163,74,0.12); color:#16a34a;">Health</span>
                                    <span class="text-muted small">Education</span>
                                </div>
                                <h5 class="fw-bold mb-2">Seasonal Health Reminders</h5>
                                <p class="text-muted mb-0">Get practical reminders on hydration, nutrition, and prevention during seasonal changes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill" style="background: rgba(22,163,74,0.12); color:#16a34a;">Notice</span>
                                    <span class="text-muted small">Clinic</span>
                                </div>
                                <h5 class="fw-bold mb-2">Patient Experience Improvements</h5>
                                <p class="text-muted mb-0">We continue to improve waiting time, communication, and service delivery quality.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.25s;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-2">Want more updates?</h5>
                        <p class="text-muted mb-0">Subscribe in the footer newsletter to receive important announcements.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
