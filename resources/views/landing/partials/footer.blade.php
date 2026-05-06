<footer class="bg-dark text-white py-10" style="background-color: #0f172a !important;">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white p-2 rounded-3 me-3 shadow-sm">
                        <img src="{{ asset('logo.png') }}" alt="Logo" height="35">
                    </div>
                    <h4 class="mb-0 text-white fw-bold">{{ config('app.name', 'UzaziClinic') }}</h4>
                </div>
                <p class="text-gray-400 mb-4" style="color: #94a3b8; line-height: 1.8;">We provide exceptional healthcare services using modern technology and a team of qualified specialists dedicated to your wellbeing.</p>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="fw-bold mb-4 text-white">Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#branches">Branches</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5 class="fw-bold mb-4 text-white">Our Services</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Reproductive Health</a></li>
                    <li><a href="#">Modern Lab</a></li>
                    <li><a href="#">Pharmacy</a></li>
                    <li><a href="#">Pediatric Clinic</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5 class="fw-bold mb-4 text-white">Contact Info</h5>
                <ul class="list-unstyled text-gray-400" style="color: #94a3b8;">
                    <li class="mb-3 d-flex align-items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-green-600"></i>
                        <span>Mlimani City, Dar es Salaam, Tanzania</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center gap-3">
                        <i class="fas fa-phone text-green-600"></i>
                        <span>+255 700 000 000</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center gap-3">
                        <i class="fas fa-envelope text-green-600"></i>
                        <span>info@uzaziclinic.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="my-5" style="border-color: rgba(255,255,255,0.1);">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 small" style="color: #64748b;">&copy; {{ date('Y') }} {{ config('app.name', 'UzaziClinic') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <div class="footer-bottom-links">
                    <a href="#" class="small me-3 text-decoration-none" style="color: #64748b;">Privacy Policy</a>
                    <a href="#" class="small text-decoration-none" style="color: #64748b;">Terms of Use</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .py-10 { padding: 80px 0; }
    .text-green-600 { color: #16a34a !important; }
    .footer-links li { margin-bottom: 12px; }
    .footer-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .footer-links a:hover {
        color: #16a34a;
        padding-left: 8px;
    }
    .social-btn {
        width: 40px;
        height: 40px;
        background-color: rgba(255,255,255,0.05);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .social-btn:hover {
        background-color: #16a34a;
        color: white;
        transform: translateY(-3px);
    }
</style>
