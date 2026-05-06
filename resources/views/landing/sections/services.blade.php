<section id="services" class="py-10" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row align-items-center mb-10 text-center">
            <div class="col-lg-12">
                <h6 class="text-uppercase mb-3 fw-bold" style="color: #16a34a; letter-spacing: 2px;">OUR SERVICES</h6>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Comprehensive Innovative Care</h2>
                <div class="mx-auto" style="width: 80px; height: 3px; background-color: #16a34a; border-radius: 2px;"></div>
                <p class="text-muted lead mt-4 mx-auto" style="max-width: 700px;">We are committed to providing quality care that meets the needs of every patient, from children to adults using modern technology.</p>
            </div>
        </div>

        <div class="row g-4">
            @php
                $services = [
                    ['icon' => 'fa-baby', 'title' => 'Reproductive Health', 'desc' => 'Quality care for expectant mothers and children from clinic commencement to delivery.'],
                    ['icon' => 'fa-microscope', 'title' => 'Modern Laboratory', 'desc' => 'All tests are available using modern machines with fast and accurate results.'],
                    ['icon' => 'fa-pills', 'title' => 'Pharmacy', 'desc' => 'All essential medicines are always available under the supervision of qualified pharmacists.'],
                    ['icon' => 'fa-user-nurse', 'title' => 'Expert Consultation', 'desc' => 'Opportunity to speak with our experts about your health at any time.'],
                    ['icon' => 'fa-heartbeat', 'title' => 'Pediatric Clinic', 'desc' => 'Monitoring child growth and all necessary vaccinations are provided here.'],
                    ['icon' => 'fa-stethoscope', 'title' => 'Health Checkup', 'desc' => 'Affordable packages for regular full body checkups and screenings.'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service-card-modern p-5 rounded-4 h-100 bg-white border-0 transition-all shadow-sm">
                    <div class="service-icon-box mb-4 shadow-sm">
                        <i class="fas {{ $service['icon'] }} fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-3 text-dark">{{ $service['title'] }}</h5>
                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ $service['desc'] }}</p>
                    <a href="#" class="service-link fw-bold text-uppercase small text-decoration-none d-flex align-items-center">
                        Read more <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .service-card-modern {
        position: relative;
        overflow: hidden;
        z-index: 1;
        border: 1px solid rgba(0,0,0,0.05) !important;
    }
    .service-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 0%;
        background-color: #16a34a;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        z-index: -1;
    }
    .service-card-modern:hover::before {
        height: 100%;
    }
    .service-card-modern:hover h5, 
    .service-card-modern:hover p,
    .service-card-modern:hover .service-link {
        color: white !important;
    }
    .service-icon-box {
        width: 70px;
        height: 70px;
        background-color: #f0fdf4;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .service-card-modern:hover .service-icon-box {
        background-color: rgba(255,255,255,0.2);
        color: white;
        transform: scale(1.1);
    }
    .service-link {
        color: #16a34a;
        letter-spacing: 1px;
    }
    .service-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(22, 163, 74, 0.15) !important;
    }
</style>

