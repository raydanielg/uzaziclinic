<footer class="footer-modern bg-dark text-white pt-10 overflow-hidden" style="background-color: #0f172a !important;">
    <div class="footer-shape-top"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-5">
            <div class="col-lg-4 animate__animated animate__fadeInLeft">
                <div class="footer-badge mb-3">
                    <span class="badge rounded-pill px-3 py-2 fw-bold footer-badge-pill">
                        <i class="fas fa-shield-alt me-2"></i>TRUSTED HEALTHCARE PLATFORM
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3 footer-logo-box">
                    <h3 class="mb-0 text-white fw-bold tracking-tight">{{ config('app.name', 'UzaziClinic') }}</h3>
                </div>
                <p class="mb-4 footer-desc">
                    Smart, secure, and patient-focused care. Built for modern clinics with fast service delivery and reliable medical support.
                </p>
                <div class="social-links-modern d-flex gap-2 mb-5">
                    <a href="#" class="social-circle-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-circle-btn"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-circle-btn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-circle-btn"><i class="fab fa-instagram"></i></a>
                </div>

                <h6 class="footer-mini-title">Contact</h6>
                <ul class="list-unstyled footer-contact-list mb-0">
                    <li class="d-flex align-items-start gap-3 mb-3">
                        <i class="fas fa-map-marker-alt mt-1 text-green-600"></i>
                        <span>Mlimani City, Dar es Salaam, Tanzania</span>
                    </li>
                    <li class="d-flex align-items-center gap-3 mb-3">
                        <i class="fas fa-envelope text-green-600"></i>
                        <span>info@uzaziclinic.com</span>
                    </li>
                    <li class="d-flex align-items-center gap-3">
                        <i class="fas fa-phone text-green-600"></i>
                        <span>+255 700 000 000</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-8 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <h6 class="footer-col-title">Quick Links</h6>
                        <ul class="list-unstyled footer-nav-links">
                            <li><a href="#hero"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                            <li><a href="{{ url('/about-us') }}"><i class="fas fa-chevron-right me-2"></i>About Us</a></li>
                            <li><a href="{{ url('/services') }}"><i class="fas fa-chevron-right me-2"></i>Services</a></li>
                            <li><a href="{{ url('/blog') }}"><i class="fas fa-chevron-right me-2"></i>Blog</a></li>
                            <li><a href="{{ url('/appointments') }}"><i class="fas fa-chevron-right me-2"></i>Appointments</a></li>
                            <li><a href="{{ url('/contact-us') }}"><i class="fas fa-chevron-right me-2"></i>Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="footer-col-title">Resources</h6>
                        <ul class="list-unstyled footer-nav-links">
                            <li><a href="{{ url('/resources/guidelines') }}"><i class="fas fa-chevron-right me-2"></i>Guidelines</a></li>
                            <li><a href="{{ url('/resources/health-tips') }}"><i class="fas fa-chevron-right me-2"></i>Health Tips</a></li>
                            <li><a href="{{ url('/blog') }}"><i class="fas fa-chevron-right me-2"></i>News</a></li>
                            <li><a href="{{ url('/resources/research') }}"><i class="fas fa-chevron-right me-2"></i>Research</a></li>
                            <li><a href="{{ url('/resources/staff-portal') }}"><i class="fas fa-chevron-right me-2"></i>Staff Portal</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="footer-col-title">Support</h6>
                        <ul class="list-unstyled footer-nav-links">
                            <li><a href="{{ url('/support/help-center') }}"><i class="fas fa-chevron-right me-2"></i>Help Center</a></li>
                            <li><a href="{{ url('/support/faqs') }}"><i class="fas fa-chevron-right me-2"></i>FAQs</a></li>
                            <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right me-2"></i>Login</a></li>
                            <li><a href="{{ route('register') }}"><i class="fas fa-chevron-right me-2"></i>Create Account</a></li>
                            <li><a href="{{ url('/support/contact-support') }}"><i class="fas fa-chevron-right me-2"></i>Contact Support</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-3">
                        <h6 class="footer-col-title">Legal</h6>
                        <ul class="list-unstyled footer-nav-links">
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Privacy Policy</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Terms of Service</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Cookie Policy</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Data Protection</a></li>
                        </ul>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="footer-newsletter rounded-4 p-4 p-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                            <h6 class="footer-col-title mb-2">Stay Updated</h6>
                            <p class="footer-newsletter-desc mb-3">Subscribe for announcements, new features, and clinic updates.</p>
                            <div class="input-group footer-input-group">
                                <input type="email" class="form-control shadow-none footer-input" placeholder="Your email address">
                                <button class="btn footer-subscribe-btn fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i>Subscribe
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom mt-5 py-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-start">
                    <p class="mb-0 small footer-bottom-text">&copy; {{ date('Y') }} {{ config('app.name', 'UzaziClinic') }}. All rights reserved.</p>
                </div>
                <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                    <a href="#hero" class="small text-decoration-none footer-bottom-link">Home</a>
                    <span class="footer-bottom-sep">|</span>
                    <a href="{{ url('/resources/staff-portal') }}" class="small text-decoration-none footer-bottom-link">Staff Portal</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-modern {
        position: relative;
        z-index: 1;
        background: radial-gradient(1200px 500px at 20% 0%, rgba(22, 163, 74, 0.12) 0%, rgba(15, 23, 42, 0) 55%),
                    radial-gradient(900px 450px at 80% 10%, rgba(34, 197, 94, 0.10) 0%, rgba(15, 23, 42, 0) 55%),
                    linear-gradient(180deg, #0b1220 0%, #0f172a 70%);
    }
    .footer-shape-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #16a34a 0%, #22c55e 100%);
    }
    .pt-10 { padding-top: 90px; }
    .text-green-600 { color: #16a34a !important; }

    .footer-badge-pill {
        background-color: rgba(255,255,255,0.06) !important;
        border: 1px solid rgba(255,255,255,0.10);
        color: #cbd5e1;
        letter-spacing: 1px;
        font-size: 0.72rem;
    }
    .footer-desc {
        color: #94a3b8;
        line-height: 1.8;
        font-size: 0.95rem;
        max-width: 360px;
    }

    .footer-mini-title {
        font-size: 0.9rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #e2e8f0;
        margin-bottom: 14px;
        font-weight: 800;
    }
    .footer-contact-list {
        color: #94a3b8;
        font-size: 0.95rem;
    }
    .footer-contact-list span { color: #94a3b8; }

    .footer-col-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #e2e8f0;
        margin-bottom: 16px;
    }
    .footer-nav-links li { margin-bottom: 12px; }
    .footer-nav-links a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
        font-size: 0.92rem;
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
        width: 40px;
        height: 40px;
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
        transform: translateY(-5px);
        background-color: rgba(22, 163, 74, 0.25);
        border-color: rgba(22, 163, 74, 0.35);
    }

    .footer-newsletter {
        background-color: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
    }
    .footer-newsletter-desc {
        color: #94a3b8;
        font-size: 0.92rem;
        margin-bottom: 16px;
    }
    .footer-input-group {
        display: flex;
        flex-wrap: nowrap;
    }
    .footer-input {
        border-radius: 12px 0 0 12px !important;
        background-color: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.10) !important;
        color: #e2e8f0 !important;
        padding: 12px 14px;
    }
    .footer-input::placeholder { color: rgba(226,232,240,0.6); }
    .footer-subscribe-btn {
        border-radius: 0 12px 12px 0 !important;
        background-color: #16a34a;
        border: 1px solid #16a34a;
        color: white;
        padding: 12px 16px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    .footer-subscribe-btn:hover {
        background-color: #15803d;
        border-color: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.25);
    }

    .footer-bottom-text { color: #64748b; }
    .footer-bottom-link {
        color: #64748b;
        transition: all 0.3s ease;
    }
    .footer-bottom-link:hover { color: #16a34a; }
    .footer-bottom-sep {
        color: rgba(100,116,139,0.6);
        margin: 0 10px;
    }

    @media (max-width: 576px) {
        .footer-input-group {
            flex-wrap: wrap;
        }
        .footer-input {
            border-radius: 12px !important;
            margin-bottom: 10px;
        }
        .footer-subscribe-btn {
            width: 100%;
            border-radius: 12px !important;
        }
    }
</style>
