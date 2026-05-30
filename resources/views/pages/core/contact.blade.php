@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-5 animate__animated animate__fadeInUp text-center">
                    <h1 class="fw-bold mb-2 display-5">Contact Us</h1>
                    <p class="text-muted mb-0 lead">We're here to help. Reach out to us for any questions about our reproductive health and family planning services.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-5 animate__animated animate__fadeInLeft" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);">
                            <div class="card-body p-4 p-md-5 text-white">
                                <h5 class="fw-bold mb-4">Get in Touch</h5>
                                
                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <div class="contact-icon bg-white bg-opacity-20 rounded-3 p-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-1">Address</div>
                                        <div class="opacity-75">Mlimani City, Dar es Salaam, Tanzania</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <div class="contact-icon bg-white bg-opacity-20 rounded-3 p-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-1">Email</div>
                                        <div class="opacity-75">info@uzaziclinic.com</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <div class="contact-icon bg-white bg-opacity-20 rounded-3 p-3">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-1">Phone Numbers</div>
                                        <div class="opacity-75">+255 678 233 736</div>
                                        <div class="opacity-75">+255 741 064 572</div>
                                        <div class="opacity-75">+255 767 825 843</div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3">
                                    <div class="contact-icon bg-white bg-opacity-20 rounded-3 p-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-1">Working Hours</div>
                                        <div class="opacity-75">Mon - Fri: 8:00 AM - 5:00 PM</div>
                                        <div class="opacity-75">Sat: 9:00 AM - 1:00 PM</div>
                                    </div>
                                </div>

                                <hr class="my-4" style="opacity: 0.2;">

                                <h6 class="fw-bold mb-3">Quick Links</h6>
                                <div class="d-flex flex-column gap-2">
                                    <a class="text-white text-decoration-none opacity-75 hover-opacity-100" href="{{ route('about') }}" style="transition: opacity 0.3s;">About Us</a>
                                    <a class="text-white text-decoration-none opacity-75 hover-opacity-100" href="{{ route('services') }}" style="transition: opacity 0.3s;">Our Services</a>
                                    <a class="text-white text-decoration-none opacity-75 hover-opacity-100" href="{{ route('appointments') }}" style="transition: opacity 0.3s;">Book Appointment</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 animate__animated animate__fadeInRight" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-lg rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <h5 class="fw-bold mb-2">Send Us a Message</h5>
                                <p class="text-muted mb-4">Have a question or need assistance? Fill out the form below and we'll get back to you shortly.</p>

                                <form id="contactPageForm" method="POST" action="{{ route('contact.submit') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Full Name *</label>
                                            <input type="text" class="form-control custom-input" name="name" required placeholder="Your full name">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email Address *</label>
                                            <input type="email" class="form-control custom-input" name="email" required placeholder="you@example.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone Number</label>
                                            <input type="tel" class="form-control custom-input" name="phone" placeholder="e.g. 0678233736">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Subject *</label>
                                            <input type="text" class="form-control custom-input" name="subject" required placeholder="What is this about?">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Message *</label>
                                            <textarea class="form-control custom-input" rows="5" name="message" required placeholder="Write your message here..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button id="contactPageSubmitBtn" type="submit" class="btn btn-success btn-lg px-5 py-3 fw-bold rounded-3 w-100">
                                                <span class="btn-text">Send Message</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                <i class="fas fa-paper-plane ms-2"></i>
                                            </button>
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
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.spinner-border');
        const originalText = btnText.textContent;

        try {
            btn.disabled = true;
            btnText.classList.add('d-none');
            spinner.classList.remove('d-none');

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
                        title: 'Message Sent!',
                        text: data.message || 'Thank you! Your message has been sent successfully.',
                        confirmButtonColor: '#16a34a',
                        timer: 3000
                    });
                } else {
                    alert('Message sent successfully!');
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
                } else {
                    alert('Failed to send message: ' + (data.message || 'Unknown error'));
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
            } else {
                alert('Network error. Please try again.');
            }
        } finally {
            btn.disabled = false;
            btnText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    });
})();
</script>
@endpush

<style>
    .contact-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }
    
    .custom-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .custom-input:focus {
        border-color: #16a34a;
        background-color: white;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);
    }
    
    .btn-success:disabled {
        opacity: 0.7;
        transform: none;
    }
</style>
@endsection
