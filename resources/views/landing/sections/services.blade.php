<section id="services" class="py-10" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row align-items-center mb-10">
            <div class="col-lg-6">
                <h6 class="text-uppercase mb-3 fw-bold" style="color: #a52a2a; letter-spacing: 2px;">TUNACHOFANYA</h6>
                <h2 class="display-5 fw-bold mb-4 text-dark" style="font-family: 'Georgia', serif;">Huduma Kamili za Kibunifu</h2>
                <div style="width: 80px; height: 3px; background-color: #a52a2a; border-radius: 2px;"></div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <p class="text-muted lead" style="font-size: 1.1rem;">Tumejizatiti kutoa huduma bora zinazokidhi mahitaji ya kila mgonjwa, kuanzia watoto hadi watu wazima kwa kutumia teknolojia ya kileo.</p>
            </div>
        </div>

        <div class="row g-4">
            @php
                $services = [
                    ['icon' => 'fa-baby', 'title' => 'Afya ya Uzazi', 'desc' => 'Huduma bora kwa mama mjamzito na mtoto kuanzia kuanza kliniki hadi kujifungua.'],
                    ['icon' => 'fa-microscope', 'title' => 'Maabara ya Kisasa', 'desc' => 'Vipimo vyote vinapatikana kwa kutumia mashine za kisasa na matokeo ya haraka.'],
                    ['icon' => 'fa-pills', 'title' => 'Famasi', 'desc' => 'Dawa zote muhimu zinapatikana wakati wote chini ya usimamizi wa wafamasia waliohitimu.'],
                    ['icon' => 'fa-user-nurse', 'title' => 'Ushauri wa Kitaalam', 'desc' => 'Pata nafasi ya kuongea na wataalam wetu kuhusu afya yako wakati wowote.'],
                    ['icon' => 'fa-heartbeat', 'title' => 'Kliniki ya Watoto', 'desc' => 'Ufuatiliaji wa ukuaji wa mtoto na chanjo zote muhimu zinatolewa hapa.'],
                    ['icon' => 'fa-stethoscope', 'title' => 'Checkup ya Afya', 'desc' => 'Vifurushi vya gharama nafuu vya kufanya vipimo vya mwili mzima mara kwa mara.'],
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service-card-modern p-5 rounded-4 h-100 bg-white border-0 transition-all shadow-sm">
                    <div class="service-icon-box mb-4">
                        <i class="fas {{ $service['icon'] }} fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-3 text-dark">{{ $service['title'] }}</h5>
                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ $service['desc'] }}</p>
                    <a href="#" class="service-link fw-bold text-uppercase small text-decoration-none">
                        Soma zaidi <i class="fas fa-arrow-right ms-2"></i>
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
    }
    .service-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 0%;
        background-color: #a52a2a;
        transition: all 0.4s ease;
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
        background-color: #f8fafc;
        color: #a52a2a;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .service-card-modern:hover .service-icon-box {
        background-color: rgba(255,255,255,0.2);
        color: white;
    }
    .service-link {
        color: #a52a2a;
        letter-spacing: 1px;
    }
    .service-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(165, 42, 42, 0.15) !important;
    }
</style>

