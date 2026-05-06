@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">FAQs</h1>
                    <p class="text-muted mb-0">Frequently asked questions about our clinic services and platform.</p>
                </div>

                <div class="accordion shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeInUp" id="faqAccordion" style="animation-delay: 0.05s;">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="q1">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true" aria-controls="a1">
                                How do I book an appointment?
                            </button>
                        </h2>
                        <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                You can book an appointment from the landing page using the appointment button, or by logging into your account and choosing a department/service. If you need urgent assistance, use the emergency contact listed on the homepage.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="q2">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false" aria-controls="a2">
                                I forgot my password. What should I do?
                            </button>
                        </h2>
                        <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Use the password reset option on the login page. If you no longer have access to your email, contact support so we can verify your identity and assist securely.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="q3">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false" aria-controls="a3">
                                Are my medical records private?
                            </button>
                        </h2>
                        <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes. Medical records are handled with strict confidentiality. Access is controlled and only authorized staff can view relevant information required to provide care.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="q4">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#a4" aria-expanded="false" aria-controls="a4">
                                Can I contact the clinic without creating an account?
                            </button>
                        </h2>
                        <div id="a4" class="accordion-collapse collapse" aria-labelledby="q4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes. You can use the contact form on the landing page. For account-specific issues, logging in helps us serve you faster.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="q5">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#a5" aria-expanded="false" aria-controls="a5">
                                How do I reach support?
                            </button>
                        </h2>
                        <div id="a5" class="accordion-collapse collapse" aria-labelledby="q5" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Visit our Contact Support page for the fastest options. You can also use the Contact Us section on the landing page.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Didn’t find your answer?</h5>
                                <p class="text-muted mb-0">Send a request and our team will respond as soon as possible.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('support.contact-support') }}" class="btn btn-success px-4 py-2 fw-bold rounded-3">
                                    Contact Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
