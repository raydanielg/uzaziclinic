<section id="hero" class="hero-section position-relative overflow-hidden pt-5 min-vh-100 d-flex align-items-center">
    <!-- Background Image with Overlay -->
    <div class="hero-bg-wrapper position-absolute top-0 start-0 w-100 h-100">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(255,255,255,0.7) 100%) !important;"></div>
        <img src="{{ asset('group-african-medical-students-college-standing-stairs.jpg') }}" 
             alt="Professional Medical Care" class="w-100 h-100 object-fit-cover">
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row min-vh-100 align-items-start justify-content-center text-center pt-10 pb-5">
            <div class="col-lg-10 animate__animated animate__fadeInUp">
                <!-- Emergency Number -->
                <div class="emergency-badge d-inline-flex align-items-center bg-green-600 text-white px-4 py-2 rounded-pill mb-4 shadow-sm fw-bold">
                    <i class="fas fa-phone-alt me-2 animate__animated animate__pulse animate__infinite"></i>
                    EMERGENCY: +255 700 000 000
                </div>

                <!-- Headline (1 line) -->
                <h1 class="display-1 fw-bold mb-4 text-dark tracking-tight main-headline" style="font-family: 'Georgia', serif;">
                    Professional <span class="text-green-600">Healthcare</span> For Your Family
                </h1>

                <!-- Sub-headline (1-2 lines) -->
                <p class="lead mb-5 text-dark fw-bold mx-auto shadow-text sub-headline" style="max-width: 800px; font-size: 1.6rem; line-height: 1.4;">
                    Experience world-class medical services with our team of expert doctors and state-of-the-art facilities dedicated to your wellbeing.
                </p>

                <!-- Buttons -->
                <div class="d-flex gap-3 flex-wrap justify-content-center mt-4">
                    <a href="#appointments" class="btn btn-green btn-lg px-5 rounded-pill shadow-lg fw-bold transition-all py-3 border-3">
                        <i class="fas fa-calendar-check me-2"></i>BOOK APPOINTMENT
                    </a>
                    <a href="#services" class="btn btn-outline-green btn-lg px-5 rounded-pill fw-bold transition-all py-3 border-3">
                        OUR SERVICES
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-section {
        min-height: 100vh;
        padding-top: 80px;
    }
    .pt-10 { padding-top: 120px; }
    .hero-bg-wrapper {
        z-index: 1;
    }
    .hero-overlay {
        background: linear-gradient(180deg, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0.7) 100%) !important;
    }
    .text-green-600 { color: #16a34a !important; }
    .bg-green-600 { background-color: #16a34a !important; }
    .btn-green {
        background-color: #16a34a;
        color: white;
        border: 3px solid #16a34a;
        transition: all 0.3s ease;
    }
    .btn-green:hover {
        background-color: #15803d;
        border-color: #15803d;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3) !important;
    }
    .btn-outline-green {
        border: 3px solid #16a34a;
        color: #16a34a;
        background: transparent;
    }
    .btn-outline-green:hover {
        background-color: #16a34a;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.2) !important;
    }
    .object-fit-cover { object-fit: cover; }
    .emergency-badge {
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
    .shadow-text {
        text-shadow: 0 2px 10px rgba(255,255,255,0.8);
    }
    .main-headline {
        font-size: clamp(2.5rem, 8vw, 4.5rem);
    }
    .sub-headline {
        font-size: clamp(1.1rem, 3vw, 1.6rem);
    }
    @media (max-width: 768px) {
        .pt-10 { padding-top: 80px; }
        .hero-section { padding-top: 60px; }
    }
</style>
