@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Appointments</h1>
                    <p class="text-muted mb-0">Request an appointment and our team will confirm the best time for you.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-5 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">How it works</h5>
                                <ul class="text-muted mb-0">
                                    <li>Choose a department/service</li>
                                    <li>Provide your details and preferred date</li>
                                    <li>We contact you to confirm availability</li>
                                    <li>Visit the clinic and receive care</li>
                                </ul>

                                <hr class="my-4" style="opacity: 0.08;">

                                <h6 class="fw-bold mb-2">Need urgent help?</h6>
                                <p class="text-muted mb-0">Call: <span class="fw-semibold">+255 678 233 736</span></p>
                                <p class="text-muted mb-0">Email: <span class="fw-semibold">info@uzaziclinic.com</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Appointment Request</h5>
                                <p class="text-muted mb-4">This is a sample request form (UI). You can connect it to your appointment system next.</p>

                                <form>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Full Name</label>
                                            <input type="text" class="form-control" placeholder="Your name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input type="text" class="form-control" placeholder="+255...">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <input type="email" class="form-control" placeholder="you@example.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Department</label>
                                            <select class="form-select">
                                                <option selected>Select department</option>
                                                <option>General Consultation</option>
                                                <option>Maternal Health</option>
                                                <option>Laboratory</option>
                                                <option>Vaccination</option>
                                                <option>Pharmacy</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Preferred Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Preferred Time</label>
                                            <select class="form-select">
                                                <option selected>Select time</option>
                                                <option>Morning</option>
                                                <option>Afternoon</option>
                                                <option>Evening</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Reason / Notes</label>
                                            <textarea class="form-control" rows="4" placeholder="Describe your concern"></textarea>
                                        </div>
                                        <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                                            <p class="text-muted mb-0 small">We will contact you to confirm the appointment time.</p>
                                            <button type="button" class="btn btn-success px-4 py-2 fw-bold rounded-3">Submit Request</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
