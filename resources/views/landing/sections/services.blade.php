<section id="services" class="py-10" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row align-items-center mb-10 text-center animate__animated animate__fadeIn">
            <div class="col-lg-12">
                <h6 class="text-uppercase mb-3 fw-bold" style="color: #16a34a; letter-spacing: 2px;">OUR SERVICES</h6>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Reproductive Health & Family Planning</h2>
                <div class="mx-auto" style="width: 80px; height: 3px; background-color: #16a34a; border-radius: 2px;"></div>
                <p class="text-muted lead mt-4 mx-auto" style="max-width: 700px;">Comprehensive, confidential, and compassionate reproductive health services designed to empower you at every stage of your family planning journey.</p>
            </div>
        </div>

        <div class="row g-4">
            @php
                $services = [
                    ['icon' => 'fa-hand-holding-heart', 'slug' => 'family-planning-counseling', 'title' => 'Family Planning Counseling', 'desc' => 'Expert guidance on contraceptive methods and family planning options tailored to your reproductive goals and health needs.', 'delay' => '0.1s'],
                    ['icon' => 'fa-person-pregnant', 'slug' => 'maternal-health', 'title' => 'Maternal & Reproductive Health', 'desc' => 'Comprehensive maternal care and reproductive health consultations from preconception to postpartum support.', 'delay' => '0.2s'],
                    ['icon' => 'fa-baby', 'slug' => 'pregnancy-care', 'title' => 'Pregnancy Testing & Prenatal Care', 'desc' => 'Reliable pregnancy testing and thorough prenatal care support to ensure a healthy pregnancy journey.', 'delay' => '0.3s'],
                    ['icon' => 'fa-book-open', 'slug' => 'health-education', 'title' => 'Reproductive Health Education', 'desc' => 'Empowering individuals and couples with knowledge about reproductive health, fertility, and informed decision-making.', 'delay' => '0.4s'],
                    ['icon' => 'fa-comments', 'slug' => 'confidential-counseling', 'title' => 'Confidential Counseling', 'desc' => 'Private and supportive counseling sessions for reproductive health concerns with complete confidentiality.', 'delay' => '0.5s'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $service['delay'] }};">
                <div class="service-card-modern p-4 rounded-4 h-100 bg-white border-0 transition-all shadow-sm">
                    <div class="service-icon-box mb-4 shadow-sm">
                        <i class="fas {{ $service['icon'] }} fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-3 text-dark">{{ $service['title'] }}</h5>
                    <p class="text-muted mb-4 small" style="line-height: 1.6;">{{ $service['desc'] }}</p>
                    <a href="{{ url('/services/' . $service['slug']) }}" class="service-link fw-bold text-uppercase small text-decoration-none d-flex align-items-center">
                        Read more <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 pt-4 animate__animated animate__fadeInUp" style="animation-delay: 1s;">
            <a href="{{ url('/services') }}" class="btn btn-green btn-lg px-5 rounded-pill shadow-lg fw-bold transition-all py-3 border-3">
                VIEW ALL SERVICES <i class="fas fa-th-large ms-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
    .service-card-modern {
        position: relative;
        overflow: hidden;
        z-index: 1;
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
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
        width: 60px;
        height: 60px;
        background-color: #f0fdf4;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
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
</style>

