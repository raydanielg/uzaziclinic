<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" height="40" class="me-2 filter-white">
                    <h4 class="mb-0 text-success fw-bold">{{ config('app.name', 'UzaziClinic') }}</h4>
                </div>
                <p class="text-muted">Tunatoa huduma bora za afya kwa kutumia teknolojia ya kisasa zaidi kwa ajili ya usalama na faraja yako.</p>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="text-white-50 hover-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="text-white-50 hover-white"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white-50 hover-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white-50 hover-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5 class="mb-4">Viungo Haraka</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="#hero" class="text-white-50 text-decoration-none">Nyumbani</a></li>
                    <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none">Sifa</a></li>
                    <li class="mb-2"><a href="#services" class="text-white-50 text-decoration-none">Huduma</a></li>
                    <li class="mb-2"><a href="#contact" class="text-white-50 text-decoration-none">Mawasiliano</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4">
                <h5 class="mb-4">Huduma Zetu</h5>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Ushauri wa Daktari</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Maabara</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Famasi</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Uzazi Salama</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h5 class="mb-4">Mawasiliano</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-3 d-flex align-items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-success"></i>
                        <span>Mlimani City, Dar es Salaam, Tanzania</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center gap-3">
                        <i class="fas fa-phone text-success"></i>
                        <span>+255 700 000 000</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center gap-3">
                        <i class="fas fa-envelope text-success"></i>
                        <span>info@uzaziclinic.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="my-5 border-secondary">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-white-50">&copy; {{ date('Y') }} {{ config('app.name', 'UzaziClinic') }}. Haki zote zimehifadhiwa.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="footer-bottom-links">
                    <a href="#" class="text-white-50 text-decoration-none me-3 small">Sera ya Faragha</a>
                    <a href="#" class="text-white-50 text-decoration-none small">Masharti ya Matumizi</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-links a:hover {
        color: #198754 !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    .hover-white:hover {
        color: white !important;
    }
    .filter-white {
        filter: brightness(0) invert(1);
    }
</style>
