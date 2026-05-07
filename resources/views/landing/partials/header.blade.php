<header class="bg-white border-bottom sticky-top shadow-sm w-100" style="z-index: 1050;">
    <!-- Top Header Row -->
    <div class="container-fluid container-lg py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <!-- Logo Section -->
            <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                <div class="logo-box me-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 50px; width: auto; object-fit: contain;" class="rounded shadow-sm">
                </div>
                <span class="h4 fw-bold text-dark mb-0 tracking-tight">{{ config('app.name', 'UzaziClinic') }}</span>
            </a>

            <!-- Contact & Auth Links -->
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-green px-3 py-2 rounded-pill fw-bold shadow-sm transition-all small">
                            <i class="fas fa-calendar-alt me-1"></i>BOOK
                        </a>
                    @else
                        <a href="{{ url('/home') }}" class="btn btn-green px-3 py-2 rounded-pill fw-bold shadow-sm transition-all small">
                            <i class="fa-solid fa-house me-1"></i>HOME
                        </a>
                    @endguest

                    <!-- Mobile Menu Toggle -->
                    <button class="btn btn-light rounded-circle shadow-sm border d-lg-none" type="button" data-bs-toggle="modal" data-bs-target="#navigationModal" style="width: 40px; height: 40px;">
                        <i class="fas fa-bars text-dark"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (Flowbite Style) -->
    <nav class="bg-light border-top border-bottom py-1 d-none d-lg-block">
        <div class="container-fluid container-lg">
            <div class="d-flex align-items-center overflow-auto no-scrollbar py-1">
                <ul class="nav flex-nowrap gap-4 text-uppercase small fw-bold list-unstyled m-0">
                    <li class="nav-item">
                        <a href="#hero" class="nav-link text-dark px-0 py-2 custom-nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/about-us') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#branches" class="nav-link text-dark px-0 py-2 custom-nav-link">Branches</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/appointments') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/services') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/blog') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/shop') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Shop</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a href="{{ url('/prescriptions') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">My Prescriptions</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/records') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Medical Records</a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a href="{{ url('/contact-us') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<style>
    :root {
        --clinic-green: #16a34a;
        --clinic-green-dark: #15803d;
    }
    .text-green-600 { color: var(--clinic-green) !important; }
    .text-green-700 { color: var(--clinic-green-dark) !important; }
    
    .btn-green {
        background-color: var(--clinic-green);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .py-2-custom {
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .btn-green:hover {
        background-color: var(--clinic-green-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3) !important;
    }
    
    .custom-nav-link {
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
        color: #374151 !important;
    }
    .custom-nav-link:hover, .custom-nav-link.active {
        color: var(--clinic-green) !important;
        border-bottom-color: var(--clinic-green);
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .hover-underline:hover {
        text-decoration: underline !important;
    }
    .tracking-tight {
        letter-spacing: -0.5px;
    }
    @media (max-width: 576px) {
        .logo-box img { height: 35px !important; }
        .logo-box { margin-right: 0.5rem !important; }
        .h4 { font-size: 0.95rem !important; letter-spacing: -0.2px !important; }
        .container-fluid { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
        .gap-3 { gap: 0.5rem !important; }
    }
</style>

<!-- Navigation Modal -->
<div class="modal fade" id="navigationModal" tabindex="-1" aria-labelledby="navigationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 35px;" class="me-2">
                    <span class="fw-bold text-dark">{{ config('app.name', 'UzaziClinic') }}</span>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="menu-grid row g-3">
                    <!-- 1 Home -->
                    <div class="col-12">
                        <a href="{{ url('/') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-home"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Home</div>
                                <div class="menu-sub">Ukurasa wa mwanzo</div>
                            </div>
                        </a>
                    </div>
                    <!-- 2 About Us -->
                    <div class="col-12">
                        <a href="{{ url('/about-us') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-info-circle"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">About Us</div>
                                <div class="menu-sub">Taarifa za kliniki</div>
                            </div>
                        </a>
                    </div>
                    <!-- 3 Branches -->
                    <div class="col-12">
                        <a href="#branches" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-map-marked-alt"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Branches</div>
                                <div class="menu-sub">Matawi yote ya kliniki</div>
                            </div>
                        </a>
                    </div>
                    <!-- 4 Appointments -->
                    <div class="col-12">
                        <a href="{{ url('/appointments') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-calendar-check"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Appointments</div>
                                <div class="menu-sub">Ukurasa wa kuweka miadi</div>
                            </div>
                        </a>
                    </div>
                    <!-- 5 Services -->
                    <div class="col-12">
                        <a href="{{ url('/services') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-hand-holding-medical"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Services</div>
                                <div class="menu-sub">Huduma zote za kliniki</div>
                            </div>
                        </a>
                    </div>
                    <!-- 6 Shop -->
                    <div class="col-12">
                        <a href="{{ url('/shop') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-shopping-basket"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Shop</div>
                                <div class="menu-sub">Kununua dawa na bidhaa</div>
                            </div>
                        </a>
                    </div>
                    <!-- 9 Contact Us -->
                    <div class="col-12">
                        <a href="{{ url('/contact-us') }}" class="menu-item-link">
                            <div class="menu-icon-box"><i class="fas fa-envelope-open-text"></i></div>
                            <div class="menu-text">
                                <div class="menu-title">Contact Us</div>
                                <div class="menu-sub">Mawasiliano</div>
                            </div>
                        </a>
                    </div>

                    @auth
                        <hr class="my-3 opacity-10">
                        <!-- 7 My Prescriptions -->
                        <div class="col-12">
                            <a href="{{ url('/prescriptions') }}" class="menu-item-link">
                                <div class="menu-icon-box auth-icon"><i class="fas fa-file-medical"></i></div>
                                <div class="menu-text">
                                    <div class="menu-title">My Prescriptions</div>
                                    <div class="menu-sub">Maagizo ya dawa yangu</div>
                                </div>
                            </a>
                        </div>
                        <!-- 8 Medical Records -->
                        <div class="col-12">
                            <a href="{{ url('/records') }}" class="menu-item-link">
                                <div class="menu-icon-box auth-icon"><i class="fas fa-history"></i></div>
                                <div class="menu-text">
                                    <div class="menu-title">Medical Records</div>
                                    <div class="menu-sub">Historia yangu ya matibabu</div>
                                </div>
                            </a>
                        </div>
                        <!-- 10 My Account -->
                        <div class="col-12">
                            <a href="{{ url('/profile') }}" class="menu-item-link">
                                <div class="menu-icon-box auth-icon"><i class="fas fa-user-circle"></i></div>
                                <div class="menu-text">
                                    <div class="menu-title">My Account</div>
                                    <div class="menu-sub">Profile yangu</div>
                                </div>
                            </a>
                        </div>
                        <!-- 11 Cart -->
                        <div class="col-12">
                            <a href="{{ route('shop.cart') }}" class="menu-item-link">
                                <div class="menu-icon-box auth-icon"><i class="fas fa-shopping-cart"></i></div>
                                <div class="menu-text">
                                    <div class="menu-title">Cart</div>
                                    <div class="menu-sub">Rukwama ya kununulia</div>
                                </div>
                            </a>
                        </div>
                        <!-- 12 Logout -->
                        <div class="col-12 mt-2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-bold">
                                    <i class="fas fa-sign-out-alt me-2"></i>LOGOUT (Kutoka)
                                </button>
                            </form>
                        </div>
                    @else
                         <hr class="my-3 opacity-10">
                         <div class="col-12">
                            <a href="{{ route('login') }}" class="btn btn-green w-100 rounded-3 py-2 fw-bold">
                                LOGIN / REGISTER
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .menu-item-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    .menu-item-link:hover {
        background: rgba(22, 163, 74, 0.08);
        border-color: rgba(22, 163, 74, 0.2);
        transform: translateX(5px);
    }
    .menu-icon-box {
        width: 42px;
        height: 42px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #16a34a;
        font-size: 1.1rem;
        margin-right: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .auth-icon {
        color: #0f172a;
        background: #f1f5f9;
    }
    .menu-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
        line-height: 1.2;
    }
    .menu-sub {
        font-size: 0.75rem;
        color: #64748b;
    }
    .modal-fullscreen-sm-down {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
</style>






