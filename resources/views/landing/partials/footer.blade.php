<footer class="footer-modern bg-dark text-white pt-10 overflow-hidden" style="background-color: #0f172a !important;">
    <!-- Top Shape Decor -->
    <div class="footer-shape-top"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-5">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-12 animate__animated animate__fadeInLeft">
                <div class="d-flex align-items-center mb-4 footer-logo-box">
                    <div class="bg-white p-2 rounded-4 me-3 shadow-lg">
                        <img src="{{ asset('logo.png') }}" alt="Logo" height="40">
                    </div>
                    <h3 class="mb-0 text-white fw-bold tracking-tight">{{ config('app.name', 'UzaziClinic') }}</h3>
                </div>
                <p class="text-slate-400 mb-5 pe-lg-4" style="color: #94a3b8; line-height: 1.8; font-size: 0.95rem;">
                    Providing world-class healthcare solutions with compassion and innovation. Your family's wellness is our primary mission and lifelong commitment.
                </p>
                <div class="social-links-modern d-flex gap-3">
                    <a href="#" class="social-circle-btn facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-circle-btn twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-circle-btn instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-circle-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <!-- Links Columns -->
            <div class="col-lg-2 col-6 col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <h5 class="fw-bold mb-4 text-white footer-title-underlined">Quick Links</h5>
                <ul class="list-unstyled footer-nav-links">
                    <li><a href="#hero"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                    <li><a href="#about"><i class="fas fa-chevron-right me-2"></i>About Us</a></li>
                    <li><a href="#branches"><i class="fas fa-chevron-right me-2"></i>Branches</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-right me-2"></i>Services</a></li>
                    <li><a href="#contact"><i class="fas fa-chevron-right me-2"></i>Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <h5 class="fw-bold mb-4 text-white footer-title-underlined">Our Services</h5>
                <ul class="list-unstyled footer-nav-links">
                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Reproductive</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Modern Lab</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Pharmacy</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Pediatric</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Surgery</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="col-lg-4 col-md-4 animate__animated animate__fadeInRight" style="animation-delay: 0.3s;">
                <h5 class="fw-bold mb-4 text-white footer-title-underlined">Newsletter</h5>
                <p class="small text-slate-400 mb-4" style="color: #94a3b8;">Subscribe to get health tips and clinic updates directly to your inbox.</p>
                <div class="newsletter-form mb-5">
                    <div class="input-group">
                        <input type="email" class="form-control bg-slate-800 border-0 py-3 text-white px-4 rounded-start-pill shadow-none" placeholder="Email Address" style="background-color: rgba(255,255,255,0.05);">
                        <button class="btn btn-green px-4 rounded-end-pill fw-bold">JOIN</button>
                    </div>
                </div>
                
                <div class="footer-contact-box bg-slate-800 p-4 rounded-4 shadow-sm border border-slate-700" style="background-color: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1) !important;">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div class="contact-icon text-green-600 fs-5"><i class="fas fa-headset"></i></div>
                        <div>
                            <div class="small text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 1px;">Emergency Call</div>
                            <div class="fw-bold text-white">+255 700 000 000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom mt-10 py-4 border-top border-slate-800" style="border-color: rgba(255,255,255,0.05) !important;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small" style="color: #64748b;">&copy; {{ date('Y') }} <span class="text-green-600 fw-bold">{{ config('app.name', 'UzaziClinic') }}</span>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <div class="footer-bottom-links">
                        <a href="#" class="small me-4 text-decoration-none transition-all hover-green" style="color: #64748b;">Privacy Policy</a>
                        <a href="#" class="small text-decoration-none transition-all hover-green" style="color: #64748b;">Terms of Use</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-modern {
        position: relative;
        z-index: 1;
    }
    .footer-shape-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #16a34a 0%, #22c55e 100%);
    }
    .py-10 { padding-top: 100px; }
    .mt-10 { margin-top: 80px; }
    .text-green-600 { color: #16a34a !important; }
    .btn-green { background-color: #16a34a; color: white; border: none; }
    .btn-green:hover { background-color: #15803d; color: white; }
    
    .footer-title-underlined {
        position: relative;
        padding-bottom: 12px;
    }
    .footer-title-underlined::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 35px;
        height: 3px;
        background-color: #16a34a;
        border-radius: 2px;
    }
    
    .footer-nav-links li { margin-bottom: 15px; }
    .footer-nav-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
        font-size: 0.95rem;
    }
    .footer-nav-links a:hover {
        color: #16a34a;
        transform: translateX(8px);
    }
    .footer-nav-links a i {
        font-size: 0.7rem;
        opacity: 0.5;
        transition: all 0.3s ease;
    }
    .footer-nav-links a:hover i { opacity: 1; color: #16a34a; }

    .social-circle-btn {
        width: 45px;
        height: 45px;
        background-color: rgba(255,255,255,0.03);
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .social-circle-btn:hover {
        color: white;
        transform: translateY(-5px) rotate(8deg);
    }
    .facebook:hover { background-color: #3b5998; border-color: #3b5998; }
    .twitter:hover { background-color: #1da1f2; border-color: #1da1f2; }
    .instagram:hover { background-color: #e1306c; border-color: #e1306c; }
    .linkedin:hover { background-color: #0077b5; border-color: #0077b5; }

    .hover-green:hover { color: #16a34a !important; }
    
    .footer-logo-box:hover .bg-white {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>
