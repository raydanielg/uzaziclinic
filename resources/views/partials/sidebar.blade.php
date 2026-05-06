@php
    $role = Auth::user()->role->name ?? 'guest';
@endphp

<div class="sidebar shadow-sm" id="sidebar">
    <div class="sidebar-header p-3 border-bottom text-center">
        <h5 class="fw-bold mb-0 text-success">AfyaCare Pro</h5>
        <small class="text-muted text-uppercase fw-bold">{{ $role }} Panel</small>
    </div>
    
    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            {{-- COMMON DASHBOARD --}}
            <li class="nav-item mb-2">
                <a class="nav-link {{ Request::is('home') || Request::is('*/dashboard') ? 'active' : '' }}" href="{{ url('/home') }}">
                    <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                </a>
            </li>

            {{-- 1. ADMIN MENU --}}
            @if($role == 'admin')
                @include('partials.menus.admin')
            @endif

            {{-- 2. DOCTOR MENU --}}
            @if($role == 'doctor')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-check me-2"></i> My Appointments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hospital-user me-2"></i> My Patients</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-medical me-2"></i> Add Prescription</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-flask-vial me-2"></i> Lab Requests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-comments me-2"></i> Chat with Patients</a>
                </li>
            @endif

            {{-- 3. NURSE MENU --}}
            @if($role == 'nurse')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-check me-2"></i> Patient Check-in</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-heart-pulse me-2"></i> Vitals Recording</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-bed me-2"></i> Ward Management</a>
                </li>
            @endif

            {{-- 4. PHARMACIST MENU --}}
            @if($role == 'pharmacist')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-pills me-2"></i> Stock Summary</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-prescription-bottle-medical me-2"></i> Pending Prescriptions</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-truck-field me-2"></i> Suppliers</a>
                </li>
            @endif

            {{-- 5. LAB TECHNICIAN MENU --}}
            @if($role == 'lab_tech')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-microscope me-2"></i> Today's Tests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-vial-circle-check me-2"></i> Enter Results</a>
                </li>
            @endif

            {{-- 6. ACCOUNTANT MENU --}}
            @if($role == 'accountant')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Create Invoice</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-receipt me-2"></i> All Receipts</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hand-holding-dollar me-2"></i> Insurance Claims</a>
                </li>
            @endif

            {{-- 7. RECEPTIONIST MENU --}}
            @if($role == 'receptionist')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-plus me-2"></i> Register Patient</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-plus me-2"></i> Book Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-viewfinder me-2"></i> Doctor Queue</a>
                </li>
            @endif

            {{-- 8. PATIENT MENU --}}
            @if($role == 'customer')
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-day me-2"></i> Book Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-store me-2"></i> Shop Products</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-medical me-2"></i> My Prescriptions</a>
                </li>
            @endif

            <li class="nav-item mt-4 border-top pt-3">
                <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: white;
        z-index: 1000;
        transition: all 0.3s;
    }
    .nav-link {
        color: #475569;
        font-weight: 500;
        padding: 0.8rem 1rem;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .nav-link:hover {
        background: #f1f5f9;
        color: #166534;
    }
    .nav-link.active {
        background: #166534;
        color: white;
    }
    .nav-link.active i {
        color: white;
    }
    .nav-link i {
        width: 20px;
        text-align: center;
        color: #64748b;
    }
</style>
