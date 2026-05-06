<section id="about" class="py-10 bg-white">
    <div class="container">
        <div class="text-center mb-10">
            <h6 class="text-uppercase mb-3 fw-bold" style="color: #16a34a; letter-spacing: 2px;">WHY CHOOSE US?</h6>
            <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Exceptional Healthcare Standards</h2>
            <div class="mx-auto" style="width: 80px; height: 3px; background-color: #16a34a; border-radius: 2px;"></div>
        </div>

        <div class="row g-5 align-items-center">
            <!-- Feature Cards Left -->
            <div class="col-lg-4">
                <div class="feature-box-modern mb-5 d-flex align-items-start gap-3 p-4 rounded-4 shadow-sm bg-light hover-lift">
                    <div class="feature-icon-wrapper bg-white shadow-sm p-3 rounded-circle">
                        <img src="https://cdn-icons-png.flaticon.com/512/3589/3589030.png" alt="Icon" width="40">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Modern Facilities</h5>
                        <p class="text-muted small mb-0">Equipped with state-of-the-art medical technology for accurate diagnosis and treatment.</p>
                    </div>
                </div>
                <div class="feature-box-modern d-flex align-items-start gap-3 p-4 rounded-4 shadow-sm bg-light hover-lift">
                    <div class="feature-icon-wrapper bg-white shadow-sm p-3 rounded-circle">
                        <i class="fas fa-user-md fs-3 text-green-600"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Expert Doctors</h5>
                        <p class="text-muted small mb-0">Our team consists of highly qualified specialists with years of clinical experience.</p>
                    </div>
                </div>
            </div>

            <!-- Central Image -->
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="central-image-wrapper position-relative">
                    <div class="rotating-border"></div>
                    <img src="{{ asset('logo.png') }}" alt="Clinic Logo" class="img-fluid position-relative z-1 p-4 bg-white rounded-circle shadow">
                </div>
            </div>

            <!-- Feature Cards Right -->
            <div class="col-lg-4">
                <div class="feature-box-modern mb-5 d-flex align-items-start gap-3 p-4 rounded-4 shadow-sm bg-light hover-lift">
                    <div class="feature-icon-wrapper bg-white shadow-sm p-3 rounded-circle">
                        <i class="fas fa-clock fs-3 text-green-600"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">24/7 Availability</h5>
                        <p class="text-muted small mb-0">We provide around-the-clock emergency services and patient support anytime you need us.</p>
                    </div>
                </div>
                <div class="feature-box-modern d-flex align-items-start gap-3 p-4 rounded-4 shadow-sm bg-light hover-lift">
                    <div class="feature-icon-wrapper bg-white shadow-sm p-3 rounded-circle">
                        <i class="fas fa-shield-alt fs-3 text-green-600"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Safe & Secure</h5>
                        <p class="text-muted small mb-0">Your medical records and privacy are protected with our advanced digital security systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .feature-box-modern {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    .feature-box-modern:hover {
        background-color: white !important;
        border-color: #16a34a;
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(22, 163, 74, 0.1) !important;
    }
    .text-green-600 { color: #16a34a !important; }
    .ls-1 { letter-spacing: 1px; }
    .central-image-wrapper {
        padding: 40px;
    }
    .rotating-border {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 2px dashed #16a34a;
        border-radius: 50%;
        animation: rotate 20s linear infinite;
        opacity: 0.3;
    }
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .hover-lift:hover {
        transform: translateY(-5px);
    }
</style>


