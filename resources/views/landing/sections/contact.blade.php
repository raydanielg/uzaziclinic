<section id="contact" class="py-10" style="background-color: #ffffff;">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 animate__animated animate__fadeInLeft">
                <h6 class="text-uppercase mb-3 fw-bold" style="color: #16a34a; letter-spacing: 2px;">GET IN TOUCH</h6>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Have a Question? We're Here to Help!</h2>
                <div style="width: 80px; height: 3px; background-color: #16a34a; border-radius: 2px;" class="mb-5"></div>
                <p class="text-muted mb-5 lead" style="font-size: 1.1rem;">Our support team is available 24/7 to assist you with anything you need regarding your health and our services.</p>
                
                <div class="contact-info-wrapper">
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="contact-icon-circle shadow-sm">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">Phone Number</h6>
                            <p class="mb-0 text-muted">+255 700 000 000</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="contact-icon-circle shadow-sm">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">Email Address</h6>
                            <p class="mb-0 text-muted">info@uzaziclinic.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="contact-icon-circle shadow-sm">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">Location</h6>
                            <p class="mb-0 text-muted">Mlimani City, Dar es Salaam</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-2xl p-4 p-md-5 rounded-5" style="background-color: #f8fafc; border: 1px solid rgba(0,0,0,0.05) !important;">
                    <h4 class="fw-bold mb-4 text-dark">Send a Quick Message</h4>
                    <form id="contactForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">YOUR NAME</label>
                                <input type="text" name="name" class="form-control border-0 py-3 shadow-none custom-input" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="form-control border-0 py-3 shadow-none custom-input" placeholder="Enter your email" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">SUBJECT</label>
                                <input type="text" name="subject" class="form-control border-0 py-3 shadow-none custom-input" placeholder="What are you contacting us about?" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">YOUR MESSAGE</label>
                                <textarea name="message" class="form-control border-0 py-3 shadow-none custom-input" rows="4" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" id="submitBtn" class="btn btn-green btn-lg px-5 w-100 rounded-pill py-3 fw-bold shadow-lg">
                                    <span class="btn-text">SEND MESSAGE</span>
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
</section>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    // Show spinner
    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    submitBtn.disabled = true;
    
    const formData = new FormData(form);
    
    fetch('{{ url("/contact/submit") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sent!',
                text: data.message,
                confirmButtonColor: '#16a34a',
                timer: 3000
            });
            form.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Something went wrong!',
                confirmButtonColor: '#16a34a'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error sending your message. Please try again.',
            confirmButtonColor: '#16a34a'
        });
    })
    .finally(() => {
        // Reset button
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
        submitBtn.disabled = false;
    });
});
</script>

<style>
    .info-card {
        background-color: #f8fafc;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    .info-card:hover {
        transform: translateX(10px);
        background-color: white;
        border-color: #16a34a;
        box-shadow: 0 10px 30px rgba(22, 163, 74, 0.1) !important;
    }
    .contact-icon-circle {
        width: 60px;
        height: 60px;
        background-color: white;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }
    .info-card:hover .contact-icon-circle {
        background-color: #16a34a;
        color: white;
        transform: rotate(10deg);
    }
    .custom-input {
        background-color: white;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb !important;
    }
    .custom-input:focus {
        background-color: white;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1) !important;
        border: 1px solid #16a34a !important;
    }
    .btn-green {
        background-color: #16a34a;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-green:hover {
        background-color: #15803d;
        color: white;
        transform: translateY(-2px);
    }
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
    }
    .rounded-5 { border-radius: 2rem !important; }
</style>

