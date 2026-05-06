<div class="sidebar shadow-sm bg-white" id="patientSidebar">
    <div class="sidebar-header p-4 border-bottom">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 40px;">
            <span class="fw-bold text-dark h5 mb-0">{{ config('app.name') }}</span>
        </div>
    </div>
    
    <div class="sidebar-body p-3 overflow-auto" style="height: calc(100vh - 85px);">
        <!-- Dashboard Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Main</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item">
                <a href="{{ route('patient.dashboard') }}" class="nav-link patient-nav-link active">
                    <i class="fas fa-th-large me-2"></i>Dashboard
                </a>
            </li>
        </ul>

        <!-- Appointments Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Appointments</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item">
                <a href="{{ route('appointments') }}" class="nav-link patient-nav-link">
                    <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link patient-nav-link d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-check me-2"></i>My Appointments</span>
                    <i class="fas fa-chevron-right small opacity-50"></i>
                </a>
                <ul class="nav flex-column ms-4 small mt-1 gap-1">
                    <li><a href="#" class="nav-link py-1 text-muted">Upcoming Appointments</a></li>
                    <li><a href="#" class="nav-link py-1 text-muted">Past Appointments</a></li>
                    <li><a href="#" class="nav-link py-1 text-muted">Appointment History</a></li>
                </ul>
            </li>
        </ul>

        <!-- Shop Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Shop / Store</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item">
                <a href="{{ route('shop.index') }}" class="nav-link patient-nav-link">
                    <i class="fas fa-shopping-bag me-2"></i>All Products
                </a>
            </li>
            <li class="nav-item"><a href="{{ route('shop.cart') }}" class="nav-link patient-nav-link"><i class="fas fa-shopping-cart me-2"></i>My Cart</a></li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-box me-2"></i>My Orders</a></li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-truck me-2"></i>Order Tracking</a></li>
        </ul>

        <!-- Medical Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Medical Services</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item">
                <a href="#" class="nav-link patient-nav-link"><i class="fas fa-file-prescription me-2"></i>My Prescriptions</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link patient-nav-link d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-notes-medical me-2"></i>Medical Records</span>
                    <i class="fas fa-chevron-right small opacity-50"></i>
                </a>
                <ul class="nav flex-column ms-4 small mt-1 gap-1">
                    <li><a href="#" class="nav-link py-1 text-muted">Medical History</a></li>
                    <li><a href="#" class="nav-link py-1 text-muted">Lab Results</a></li>
                    <li><a href="#" class="nav-link py-1 text-muted">Visit History</a></li>
                </ul>
            </li>
        </ul>

        <!-- Finance Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Payments & Billing</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item">
                <a href="#" class="nav-link patient-nav-link"><i class="fas fa-receipt me-2"></i>Receipts & Invoices</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-credit-card me-2"></i>Make Payment</a></li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-history me-2"></i>Payment History</a></li>
        </ul>

        <!-- Communication Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Communication</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-comments me-2"></i>Chat with Doctor</a></li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-bell me-2"></i>Notifications</a></li>
        </ul>

        <!-- Insurance Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Insurance</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-shield-alt me-2"></i>My Insurance Info</a></li>
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-file-invoice-dollar me-2"></i>Claims Status</a></li>
        </ul>

        <!-- Account Section -->
        <div class="menu-label small text-muted text-uppercase fw-bold mb-2 ps-2">Settings</div>
        <ul class="nav flex-column gap-1 mb-4">
            <li class="nav-item"><a href="#" class="nav-link patient-nav-link"><i class="fas fa-user-circle me-2"></i>My Profile</a></li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link patient-nav-link text-danger border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
    #patientSidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
    }
    .patient-nav-link {
        color: #475569;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .patient-nav-link:hover, .patient-nav-link.active {
        background: rgba(22, 163, 74, 0.08);
        color: #16a34a;
    }
    .patient-nav-link i {
        width: 20px;
        text-align: center;
    }
    .menu-label {
        letter-spacing: 0.5px;
        font-size: 0.7rem;
    }
    @media (max-width: 991px) {
        #patientSidebar {
            transform: translateX(-100%);
        }
        #patientSidebar.show {
            transform: translateX(0);
        }
    }
</style>
