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
            <div class="d-flex align-items-center gap-4">
                <div class="d-none d-md-flex align-items-center text-muted small fw-medium">
                    <i class="fas fa-phone-alt me-2 text-green-600"></i>
                    <span>+255 700 000 000</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('contact') }}" class="text-green-700 text-decoration-none small fw-bold hover-underline">Contact us</a>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-green px-4 py-2-custom rounded-pill fw-bold shadow-sm transition-all">
                            <i class="fas fa-calendar-alt me-2"></i>MAKE APPOINTMENT
                        </a>
                    @else
                        <a href="{{ url('/home') }}" class="btn btn-green px-4 py-2-custom rounded-pill fw-bold shadow-sm transition-all">
                            <i class="fa-solid fa-house me-2"></i>DASHBOARD
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (Flowbite Style) -->
    <nav class="bg-light border-top border-bottom py-1">
        <div class="container-fluid container-lg">
            <div class="d-flex align-items-center overflow-auto no-scrollbar py-1">
                <ul class="nav flex-nowrap gap-4 text-uppercase small fw-bold list-unstyled m-0">
                    <li class="nav-item">
                        <a href="#hero" class="nav-link text-dark px-0 py-2 custom-nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#branches" class="nav-link text-dark px-0 py-2 custom-nav-link">Branches</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('appointments') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('services') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('blog.index') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#shop" class="nav-link text-dark px-0 py-2 custom-nav-link">Shop</a>
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
                        <a href="{{ route('contact') }}" class="nav-link text-dark px-0 py-2 custom-nav-link">Contact Us</a>
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
        .logo-box img { height: 40px !important; }
        .h4 { font-size: 1.1rem !important; }
    }
</style>






