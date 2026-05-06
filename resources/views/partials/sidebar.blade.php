@php
    $user = Auth::user();
    $roleName = null;
    if ($user && $user->role_id) {
        $roleName = \App\Models\Role::find($user->role_id)->name ?? 'guest';
    }
@endphp

<div class="sidebar shadow-sm" id="sidebar">
    <div class="sidebar-header p-3 border-bottom text-center">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid mb-2" style="max-height: 50px;">
        <br>
        <small class="text-muted text-uppercase fw-bold">{{ $roleName }} Panel</small>
    </div>
    
    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            {{-- 1. ADMIN MENU --}}
            @if($roleName == 'admin')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                @include('partials.menus.admin')
            @endif

            {{-- 2. DOCTOR MENU --}}
            @if($roleName == 'doctor')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/dashboard') ? 'active' : '' }}" href="{{ url('/doctor/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-vial-circle-check me-2"></i> Lab Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-notes-medical me-2"></i> Medical Records</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-days me-2"></i> My Schedule</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-comments me-2"></i> Chat with Patients</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-line me-2"></i> Reports (My Performance)</a>
                </li>
            @endif

            {{-- 3. NURSE MENU --}}
            @if($roleName == 'nurse')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('nurse/dashboard') ? 'active' : '' }}" href="{{ url('/nurse/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-check me-2"></i> Patient Check-in</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-people-arrows me-2"></i> Waiting Queue</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-heart-pulse me-2"></i> Vitals Recording</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-day me-2"></i> Today's Appointments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-doctor me-2"></i> Assist Doctor List</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-rectangle me-2"></i> Patient Management</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-bed-pulse me-2"></i> Bed Allocation</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hospital me-2"></i> Ward Management</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-vial me-2"></i> Lab Sample Collection</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-pills me-2"></i> Medication Administration</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-invoice me-2"></i> Reports (Daily Tasks)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                </li>
            @endif

            {{-- 4. PHARMACIST MENU --}}
            @if($roleName == 'pharmacist')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('pharmacist/dashboard') ? 'active' : '' }}" href="{{ url('/pharmacist/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-triangle-exclamation me-2"></i> Stock Summary</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-pills me-2"></i> All Medicines</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-plus-circle me-2"></i> Add New Medicine</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-right-left me-2"></i> Stock In / Out</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-truck-moving me-2"></i> Stock Transfer</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-prescription me-2"></i> Pending Prescriptions</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-medical me-2"></i> Process Prescription</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-history me-2"></i> Prescription History</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-shopping-cart me-2"></i> Medicine Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-spinner me-2"></i> Process Online Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-list-check me-2"></i> Order History</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-truck-field me-2"></i> Suppliers List</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-invoice me-2"></i> Purchase Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-bar me-2"></i> Reports (Stock/Sales/Expiry)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-cog me-2"></i> Settings (Categories/Units)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                </li>
            @endif

            {{-- 5. LAB TECHNICIAN MENU --}}
            @if($roleName == 'lab_tech')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('lab/dashboard') ? 'active' : '' }}" href="{{ url('/lab/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-microscope me-2"></i> Today's Tests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-vial-circle-check me-2"></i> Enter Results</a>
                </li>
            @endif

            {{-- 6. ACCOUNTANT MENU --}}
            @if($roleName == 'accountant')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('accountant/dashboard') ? 'active' : '' }}" href="{{ url('/accountant/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
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
            @if($roleName == 'receptionist')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('receptionist/dashboard') ? 'active' : '' }}" href="{{ url('/receptionist/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
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
            @if($roleName == 'customer')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('patient/dashboard') ? 'active' : '' }}" href="{{ url('/patient/dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
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
