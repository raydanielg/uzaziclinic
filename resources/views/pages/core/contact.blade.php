@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Contact Us</h1>
                    <p class="text-muted mb-0">Send us a message and we will respond as soon as possible.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-5 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-3">Contact Information</h5>
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <i class="fas fa-map-marker-alt mt-1" style="color:#16a34a;"></i>
                                    <div>
                                        <div class="fw-semibold">Address</div>
                                        <div class="text-muted">Mlimani City, Dar es Salaam, Tanzania</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <i class="fas fa-envelope mt-1" style="color:#16a34a;"></i>
                                    <div>
                                        <div class="fw-semibold">Email</div>
                                        <div class="text-muted">info@uzaziclinic.com</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-phone mt-1" style="color:#16a34a;"></i>
                                    <div>
                                        <div class="fw-semibold">Phone</div>
                                        <div class="text-muted">+255 678 233 736</div>
                                        <div class="text-muted">+255 741 064 572</div>
                                        <div class="text-muted">+255 767 825 843</div>
                                    </div>
                                </div>

                                <hr class="my-4" style="opacity: 0.08;">

                                <h6 class="fw-bold mb-2">Support Links</h6>
                                <div class="d-flex flex-column gap-2">
                                    <a class="text-decoration-none" href="{{ route('support.help-center') }}">Help Center</a>
                                    <a class="text-decoration-none" href="{{ route('support.faqs') }}">FAQs</a>
                                    <a class="text-decoration-none" href="{{ route('support.contact-support') }}">Contact Support</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Send a Message</h5>
                                <p class="text-muted mb-4">This page uses the same contact submission endpoint used on the landing page.</p>

                                <form id="contactPageForm" method="POST" action="{{ route('contact.submit') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Full Name</label>
                                            <input type="text" class="form-control" name="name" required placeholder="Your name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <input type="email" class="form-control" name="email" required placeholder="you@example.com">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Subject</label>
                                            <input type="text" class="form-control" name="subject" required placeholder="Subject">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Message</label>
                                            <textarea class="form-control" rows="5" name="message" required placeholder="Write your message"></textarea>
                                        </div>
                                        <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                                            <p class="text-muted mb-0 small">We will reply via email once we receive your message.</p>
                                            <button id="contactPageSubmitBtn" type="submit" class="btn btn-success px-4 py-2 fw-bold rounded-3">Send Message</button>
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

@push('js')
<script>
(function () {
    const form = document.getElementById('contactPageForm');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn = document.getElementById('contactPageSubmitBtn');
        const original = btn ? btn.innerHTML : '';

        try {
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';
            }

            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            const data = await res.json();

            if (data.success) {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent',
                        text: data.message || 'Thank you! Your message has been sent successfully.',
                        confirmButtonColor: '#16a34a'
                    });
                }
                form.reset();
            } else {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: data.message || 'Sorry, something went wrong. Please try again.',
                        confirmButtonColor: '#16a34a'
                    });
                }
            }
        } catch (err) {
            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Please check your internet connection and try again.',
                    confirmButtonColor: '#16a34a'
                });
            }
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = original;
            }
        }
    });
})();
</script>
@endpush
@endsection
