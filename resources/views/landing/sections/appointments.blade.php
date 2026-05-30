<section id="appointments" class="py-10" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 animate__animated animate__fadeInLeft">
                <h6 class="text-uppercase mb-3 fw-bold" style="color: #16a34a; letter-spacing: 2px;">BOOK APPOINTMENT</h6>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Schedule Your Visit Today</h2>
                <div style="width: 80px; height: 3px; background-color: #16a34a; border-radius: 2px;" class="mb-5"></div>
                <p class="text-muted mb-5 lead" style="font-size: 1.1rem;">Book your appointment online and our team will confirm your visit via SMS. No registration required - just fill in your details and we'll take care of the rest.</p>
                
                <div class="booking-info-wrapper">
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="booking-icon-circle shadow-sm">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">Easy Booking</h6>
                            <p class="mb-0 text-muted">Fill the form and get instant confirmation</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="booking-icon-circle shadow-sm">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">No Registration</h6>
                            <p class="mb-0 text-muted">We'll create your profile automatically</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 gap-4 p-4 rounded-4 shadow-sm info-card">
                        <div class="booking-icon-circle shadow-sm">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">SMS Confirmation</h6>
                            <p class="mb-0 text-muted">Receive confirmation via SMS instantly</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-2xl p-4 p-md-5 rounded-5" style="background-color: #ffffff; border: 1px solid rgba(0,0,0,0.05) !important;">
                    <h4 class="fw-bold mb-4 text-dark">Book Your Appointment</h4>
                    <form id="appointmentBookingForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">FULL NAME *</label>
                                <input type="text" name="name" class="form-control border-0 py-3 shadow-none custom-input" placeholder="Enter your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">PHONE NUMBER *</label>
                                <input type="tel" name="phone" class="form-control border-0 py-3 shadow-none custom-input" placeholder="e.g. 0678233736" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="form-control border-0 py-3 shadow-none custom-input" placeholder="you@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">DATE OF BIRTH</label>
                                <input type="date" name="date_of_birth" class="form-control border-0 py-3 shadow-none custom-input">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">PREFERRED DATE *</label>
                                <input type="date" name="appointment_date" class="form-control border-0 py-3 shadow-none custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small">PREFERRED TIME *</label>
                                <select name="appointment_time" class="form-control border-0 py-3 shadow-none custom-input" required>
                                    <option value="">Select time</option>
                                    <option value="08:00">08:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">SERVICE TYPE *</label>
                                <select name="service_type" class="form-control border-0 py-3 shadow-none custom-input" required>
                                    <option value="">Select service</option>
                                    <option value="family-planning">Family Planning Counseling</option>
                                    <option value="maternal-health">Maternal Health Consultation</option>
                                    <option value="pregnancy-care">Pregnancy Care</option>
                                    <option value="health-education">Health Education</option>
                                    <option value="confidential-counseling">Confidential Counseling</option>
                                    <option value="general">General Consultation</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small">REASON FOR VISIT</label>
                                <textarea name="reason" class="form-control border-0 py-3 shadow-none custom-input" rows="3" placeholder="Briefly describe your reason for visit..."></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" id="bookingSubmitBtn" class="btn btn-green btn-lg px-5 w-100 rounded-pill py-3 fw-bold shadow-lg">
                                    <span class="btn-text">BOOK APPOINTMENT</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <i class="fas fa-calendar-check ms-2"></i>
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
document.getElementById('appointmentBookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('bookingSubmitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    // Show spinner
    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    submitBtn.disabled = true;
    
    const formData = new FormData(form);
    
    fetch('{{ url("/api/appointment/book") }}', {
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
                title: 'Appointment Booked!',
                text: data.message,
                confirmButtonColor: '#16a34a',
                timer: 4000
            });
            form.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Booking Failed',
                text: data.message || 'Something went wrong!',
                confirmButtonColor: '#16a34a'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error booking your appointment. Please try again.',
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
        background-color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    .info-card:hover {
        transform: translateX(10px);
        background-color: #f8fafc;
        border-color: #16a34a;
        box-shadow: 0 10px 30px rgba(22, 163, 74, 0.1) !important;
    }
    .booking-icon-circle {
        width: 60px;
        height: 60px;
        background-color: #16a34a;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }
    .info-card:hover .booking-icon-circle {
        background-color: #15803d;
        transform: rotate(10deg);
    }
    .custom-input {
        background-color: #f8fafc;
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
