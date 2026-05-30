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
                                <h5 class="fw-bold mb-2">Book Your Appointment</h5>
                                <p class="text-muted mb-4">Fill in your details and we'll confirm your appointment via SMS.</p>

                                <form id="appointmentPageForm">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Full Name *</label>
                                            <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone Number *</label>
                                            <input type="tel" name="phone" class="form-control" placeholder="e.g. 0678233736" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <input type="email" name="email" class="form-control" placeholder="you@example.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Date of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Service Type *</label>
                                            <select name="service_type" class="form-select" required>
                                                <option value="">Select service</option>
                                                <option value="family-planning">Family Planning Counseling</option>
                                                <option value="maternal-health">Maternal Health Consultation</option>
                                                <option value="pregnancy-care">Pregnancy Care</option>
                                                <option value="health-education">Health Education</option>
                                                <option value="confidential-counseling">Confidential Counseling</option>
                                                <option value="general">General Consultation</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Preferred Date *</label>
                                            <input type="date" name="appointment_date" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Preferred Time *</label>
                                            <select name="appointment_time" class="form-select" required>
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
                                            <label class="form-label fw-semibold">Reason for Visit</label>
                                            <textarea name="reason" class="form-control" rows="4" placeholder="Briefly describe your reason for visit..."></textarea>
                                        </div>
                                        <div class="col-12 d-flex flex-column flex-md-row gap-2 justify-content-between align-items-md-center">
                                            <p class="text-muted mb-0 small">You will receive SMS confirmation after booking.</p>
                                            <button type="submit" id="appointmentPageSubmitBtn" class="btn btn-success px-4 py-2 fw-bold rounded-3">Book Appointment</button>
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
document.getElementById('appointmentPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('appointmentPageSubmitBtn');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Booking...';
    
    const formData = new FormData(form);
    
    fetch('{{ url("/api/appointment/book") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Appointment Booked!',
                    text: data.message,
                    confirmButtonColor: '#16a34a',
                    timer: 4000
                });
            } else {
                alert('Appointment booked successfully! You will receive SMS confirmation.');
            }
            form.reset();
        } else {
            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Booking Failed',
                    text: data.message || 'Something went wrong!',
                    confirmButtonColor: '#16a34a'
                });
            } else {
                alert('Failed to book appointment: ' + (data.message || 'Unknown error'));
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.Swal) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error booking your appointment. Please try again.',
                confirmButtonColor: '#16a34a'
            });
        } else {
            alert('Error booking appointment. Please try again.');
        }
    })
    .finally(() => {
        // Reset button
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>
@endpush
@endsection
