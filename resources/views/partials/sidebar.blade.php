@php
    $user = Auth::user();
    $roleName = null;
    if ($user && $user->role_id) {
        $roleName = \App\Models\Role::find($user->role_id)->name ?? 'guest';
    }
@endphp

<div class="sidebar shadow-sm" id="sidebar">
    <div class="sidebar-header p-4 border-bottom text-center position-relative bg-dark text-white">
        <button class="btn btn-sm btn-outline-light position-absolute end-0 top-50 translate-middle-y d-lg-none me-2" id="sidebarClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="mb-2">
            @if($roleName == 'admin')
                <i class="fa-solid fa-user-shield fa-2xl text-warning"></i>
            @else
                <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 45px;">
            @endif
        </div>
        <h6 class="mb-0 fw-bold tracking-wider text-uppercase">{{ $roleName == 'admin' ? 'Super Admin' : $roleName }}</h6>
        <small class="text-uppercase opacity-50 small" style="font-size: 0.6rem;">{{ $roleName == 'admin' ? 'System Controller' : 'Panel' }}</small>
    </div>
    
    <div class="sidebar-menu p-3" style="height: calc(100vh - 110px); overflow-y: auto;">
        <ul class="nav flex-column">
            {{-- 1. SUPER ADMIN / MANAGEMENT MENU --}}
            @if($roleName == 'admin')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-shield-halved me-2"></i> System Control Panel
                    </a>
                </li>
                
                {{-- Global Overview Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">System Management</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fa-solid fa-users-gear me-2 text-primary"></i> User Accounts
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}" href="{{ route('admin.users.roles') }}">
                        <i class="fa-solid fa-user-shield me-2 text-info"></i> Access Control (Roles)
                    </a>
                </li>

                {{-- Clinic Operations --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Clinic Management</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/appointments*') ? 'active' : '' }}" href="{{ route('admin.appointments.index') }}">
                        <i class="fa-solid fa-calendar-check me-2 text-primary"></i> Master Appointments
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/doctors*') ? 'active' : '' }}" href="{{ route('admin.doctors.index') }}">
                        <i class="fa-solid fa-user-doctor me-2 text-success"></i> Medical Staff
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/patients*') ? 'active' : '' }}" href="{{ route('admin.patients.index') }}">
                        <i class="fa-solid fa-hospital-user me-2 text-danger"></i> Patient Database
                    </a>
                </li>

                {{-- Business & Inventory --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Enterprise & Logistics</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/store*') ? 'active' : '' }}" href="{{ route('admin.store.index') }}">
                        <i class="fa-solid fa-boxes-stacked me-2 text-warning"></i> Inventory & Products
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/medical*') ? 'active' : '' }}" href="{{ route('admin.medical.records') }}">
                        <i class="fa-solid fa-file-medical me-2 text-info"></i> Clinical Records Rx
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/finance*') ? 'active' : '' }}" href="{{ route('admin.finance.invoices') }}">
                        <i class="fa-solid fa-file-invoice-dollar me-2 text-success"></i> Financial Management
                    </a>
                </li>

                {{-- Platform Maintenance --}}
                <li class="nav-item-header mt-4 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">System Health</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/analytics*') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                        <i class="fa-solid fa-chart-line me-2 text-warning"></i> Platform Analytics
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings.general') }}">
                        <i class="fa-solid fa-sliders me-2 text-secondary"></i> Global Configurations
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.users.logs') }}">
                        <i class="fa-solid fa-shield-virus me-2 text-dark"></i> Security Audit Logs
                    </a>
                </li>
            @endif

            {{-- 2. PATIENT / CUSTOMER MENU --}}
            @if($roleName == 'customer')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('patient/dashboard') ? 'active' : '' }}" href="{{ route('patient.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>

                {{-- Appointments Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Appointments</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/appointments/book') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-calendar-plus me-2 text-primary"></i> Book Appointment
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/appointments') && !Request::is('patient/appointments/*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-calendar-check me-2 text-success"></i> My Appointments
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/appointments/upcoming') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-calendar-day me-2 text-info"></i> Upcoming Appointments
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/appointments/history') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i> Appointment History
                    </a>
                </li>

                {{-- Shop Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Shop / Store</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('shop*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-shop me-2 text-warning"></i> All Products
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('cart*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-cart-shopping me-2 text-primary"></i> My Cart
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/orders*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-bag-shopping me-2 text-danger"></i> My Orders
                    </a>
                </li>

                {{-- Medical Services Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Medical Services</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/prescriptions*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-file-prescription me-2 text-success"></i> My Prescriptions
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/medical-records*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-folder-tree me-2 text-primary"></i> Medical Records
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/lab-results*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-flask-vial me-2 text-warning"></i> Lab Results
                    </a>
                </li>

                {{-- Payments Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Payments & Billing</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/invoices*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-file-invoice-dollar me-2 text-danger"></i> Receipts & Invoices
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/payments*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-credit-card me-2 text-success"></i> Payment History
                    </a>
                </li>

                {{-- Communication --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Communication</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/chat*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-comments me-2 text-primary"></i> Chat with Doctor
                    </a>
                </li>

                {{-- Insurance Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Insurance</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/insurance*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-shield-heart me-2 text-danger"></i> My Insurance Info
                    </a>
                </li>

                {{-- Settings --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Settings</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('patient/profile*') ? 'active' : '' }}" href="#">
                        <i class="fa-solid fa-user-gear me-2 text-secondary"></i> My Profile
                    </a>
                </li>
            @endif

            {{-- 2. DOCTOR MENU --}}
            @if($roleName == 'doctor')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/dashboard') ? 'active' : '' }}" href="{{ route('doctor.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/patients*') ? 'active' : '' }}" href="{{ route('doctor.patients') }}">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i> My Patients
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/prescriptions*') ? 'active' : '' }}" href="{{ route('doctor.prescriptions.add') }}">
                        <i class="fa-solid fa-file-medical me-2 text-info"></i> Add Prescription
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/lab-requests*') ? 'active' : '' }}" href="{{ route('doctor.lab.requests') }}">
                        <i class="fa-solid fa-flask-vial me-2 text-warning"></i> Lab Requests
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/lab-results*') ? 'active' : '' }}" href="{{ route('doctor.lab.results') }}">
                        <i class="fa-solid fa-vial-circle-check me-2 text-success"></i> Lab Results
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/medical-records*') ? 'active' : '' }}" href="{{ route('doctor.medical.records') }}">
                        <i class="fa-solid fa-notes-medical me-2 text-primary"></i> Medical Records
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/schedule*') ? 'active' : '' }}" href="{{ route('doctor.schedule') }}">
                        <i class="fa-solid fa-calendar-days me-2 text-info"></i> My Schedule
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/chat*') ? 'active' : '' }}" href="{{ route('doctor.chat') }}">
                        <i class="fa-solid fa-comments me-2 text-primary"></i> Chat with Patients
                    </a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Account</li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/profile*') ? 'active' : '' }}" href="{{ route('doctor.profile') }}">
                        <i class="fa-solid fa-user-circle me-2 text-secondary"></i> My Profile
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/password*') ? 'active' : '' }}" href="{{ route('doctor.password') }}">
                        <i class="fa-solid fa-key me-2 text-danger"></i> Change Password
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('doctor/reports*') ? 'active' : '' }}" href="{{ route('doctor.reports') }}">
                        <i class="fa-solid fa-chart-line me-2 text-warning"></i> Reports (My Performance)
                    </a>
                </li>
            @endif

            {{-- 3. NURSE MENU --}}
            @if($roleName == 'nurse')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('nurse/dashboard') ? 'active' : '' }}" href="{{ route('nurse.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Patient Care</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/checkin') ? 'active' : '' }}" href="{{ route('nurse.checkin') }}"><i class="fa-solid fa-user-check me-2 text-primary"></i> Patient Check-in</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/queue') ? 'active' : '' }}" href="{{ route('nurse.queue') }}"><i class="fa-solid fa-people-arrows me-2 text-warning"></i> Waiting Queue</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/vitals') ? 'active' : '' }}" href="{{ route('nurse.vitals') }}"><i class="fa-solid fa-heart-pulse me-2 text-danger"></i> Vitals Recording</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/appointments') ? 'active' : '' }}" href="{{ route('nurse.appointments') }}"><i class="fa-solid fa-calendar-day me-2 text-info"></i> Today's Appointments</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/assist-doctor') ? 'active' : '' }}" href="{{ route('nurse.assist-doctor') }}"><i class="fa-solid fa-user-doctor me-2 text-success"></i> Assist Doctor</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/patients') ? 'active' : '' }}" href="{{ route('nurse.patients') }}"><i class="fa-solid fa-users-rectangle me-2 text-primary"></i> Patient Management</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Ward & Lab</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/bed-allocation') ? 'active' : '' }}" href="{{ route('nurse.bed-allocation') }}"><i class="fa-solid fa-bed-pulse me-2 text-warning"></i> Bed Allocation</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/wards') ? 'active' : '' }}" href="{{ route('nurse.wards') }}"><i class="fa-solid fa-hospital me-2 text-info"></i> Ward Management</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/lab-collection') ? 'active' : '' }}" href="{{ route('nurse.lab-collection') }}"><i class="fa-solid fa-vial me-2 text-danger"></i> Lab Sample Collection</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/medication') ? 'active' : '' }}" href="{{ route('nurse.medication') }}"><i class="fa-solid fa-pills me-2 text-success"></i> Medication Administration</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/reports') ? 'active' : '' }}" href="{{ route('nurse.reports') }}"><i class="fa-solid fa-file-invoice me-2 text-secondary"></i> Reports</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/profile') ? 'active' : '' }}" href="{{ route('nurse.profile') }}"><i class="fa-solid fa-user-circle me-2 text-primary"></i> My Profile</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('nurse/password') ? 'active' : '' }}" href="{{ route('nurse.password') }}"><i class="fa-solid fa-key me-2 text-danger"></i> Change Password</a>
                </li>
            @endif

            {{-- 4. PHARMACIST MENU --}}
            @if($roleName == 'pharmacist')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('pharmacist/dashboard') ? 'active' : '' }}" href="{{ route('pharmacist.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Dashboard
                    </a>
                </li>
                
                {{-- Inventory Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Inventory & Stock</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/stock-summary') ? 'active' : '' }}" href="{{ route('pharmacist.stock-summary') }}">
                        <i class="fa-solid fa-chart-pie me-2 text-info"></i> Stock Summary
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/inventory') ? 'active' : '' }}" href="{{ route('pharmacist.inventory') }}">
                        <i class="fa-solid fa-pills me-2 text-success"></i> All Medicines
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/medicines/create') ? 'active' : '' }}" href="{{ route('pharmacist.medicines.create') }}">
                        <i class="fa-solid fa-plus-circle me-2 text-primary"></i> Add New Medicine
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/stock-move') ? 'active' : '' }}" href="{{ route('pharmacist.stock-move') }}">
                        <i class="fa-solid fa-right-left me-2 text-warning"></i> Stock In / Out
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-truck-moving me-2 text-secondary"></i> Stock Transfer
                    </a>
                </li>

                {{-- Prescriptions Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Prescriptions</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/prescriptions') && !Request::is('pharmacist/prescriptions/history') ? 'active' : '' }}" href="{{ route('pharmacist.prescriptions') }}">
                        <i class="fa-solid fa-file-prescription me-2 text-danger"></i> Pending Prescriptions
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-file-medical me-2 text-primary"></i> Process Prescription
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/prescriptions/history') ? 'active' : '' }}" href="{{ route('pharmacist.prescriptions.history') }}">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-secondary"></i> Prescription History
                    </a>
                </li>

                {{-- Orders Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Orders & Procurement</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/orders') ? 'active' : '' }}" href="{{ route('pharmacist.orders') }}">
                        <i class="fa-solid fa-shopping-cart me-2 text-warning"></i> Medicine Orders
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/online-orders') ? 'active' : '' }}" href="{{ route('pharmacist.online-orders') }}">
                        <i class="fa-solid fa-spinner me-2 text-info"></i> Process Online Orders
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-list-check me-2 text-success"></i> Order History
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/suppliers') ? 'active' : '' }}" href="{{ route('pharmacist.suppliers') }}">
                        <i class="fa-solid fa-truck-field me-2 text-primary"></i> Suppliers List
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-file-invoice me-2 text-secondary"></i> Purchase Orders
                    </a>
                </li>

                {{-- Reports & Settings --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Admin & Reports</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/reports') ? 'active' : '' }}" href="{{ route('pharmacist.reports') }}">
                        <i class="fa-solid fa-chart-bar me-2 text-warning"></i> Reports (Stock/Sales/Expiry)
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/settings') ? 'active' : '' }}" href="{{ route('pharmacist.settings') }}">
                        <i class="fa-solid fa-cog me-2 text-secondary"></i> Settings (Categories/Units)
                    </a>
                </li>

                {{-- Account Section --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">My Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/profile') ? 'active' : '' }}" href="{{ route('pharmacist.profile') }}">
                        <i class="fa-solid fa-user-circle me-2 text-primary"></i> My Profile
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('pharmacist/password') ? 'active' : '' }}" href="{{ route('pharmacist.password') }}">
                        <i class="fa-solid fa-key me-2 text-danger"></i> Change Password
                    </a>
                </li>
            @endif

            {{-- 5. LAB TECHNICIAN MENU --}}
            @if($roleName == 'lab_tech')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('lab/dashboard') ? 'active' : '' }}" href="{{ route('lab.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Lab Work</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/requests') ? 'active' : '' }}" href="{{ route('lab.requests') }}"><i class="fa-solid fa-flask me-2 text-danger"></i> Lab Requests</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/tests') ? 'active' : '' }}" href="{{ route('lab.tests') }}"><i class="fa-solid fa-vial-circle-check me-2 text-success"></i> Tests Catalog</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/equipment') ? 'active' : '' }}" href="{{ route('lab.equipment') }}"><i class="fa-solid fa-microscope me-2 text-info"></i> Equipment</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/profile') ? 'active' : '' }}" href="{{ route('lab.profile') }}"><i class="fa-solid fa-user-circle me-2 text-primary"></i> My Profile</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/password') ? 'active' : '' }}" href="{{ route('lab.password') }}"><i class="fa-solid fa-key me-2 text-danger"></i> Change Password</a>
                </li>
            @endif

            {{-- 6. ACCOUNTANT MENU --}}
            @if($roleName == 'accountant')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('accountant/dashboard') ? 'active' : '' }}" href="{{ route('accountant.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Billing & Finance</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('accountant/invoices') ? 'active' : '' }}" href="{{ route('accountant.invoices') }}"><i class="fa-solid fa-file-invoice-dollar me-2 text-warning"></i> Invoices</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('accountant/payments') ? 'active' : '' }}" href="{{ route('accountant.payments') }}"><i class="fa-solid fa-money-bill-wave me-2 text-success"></i> Payments</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('accountant/reports') ? 'active' : '' }}" href="{{ route('accountant.reports') }}"><i class="fa-solid fa-chart-line me-2 text-info"></i> Financial Reports</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('accountant/profile') ? 'active' : '' }}" href="{{ route('accountant.profile') }}"><i class="fa-solid fa-user-circle me-2 text-primary"></i> My Profile</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('accountant/password') ? 'active' : '' }}" href="{{ route('accountant.password') }}"><i class="fa-solid fa-key me-2 text-danger"></i> Change Password</a>
                </li>
            @endif

            {{-- 7. RECEPTIONIST MENU --}}
            @if($roleName == 'receptionist')
                <li class="nav-item mb-2">
                    <a class="nav-link {{ Request::is('receptionist/dashboard') ? 'active' : '' }}" href="{{ route('receptionist.dashboard') }}">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Patient Management</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('receptionist/patients') ? 'active' : '' }}" href="{{ route('receptionist.patients') }}"><i class="fa-solid fa-user-plus me-2 text-success"></i> Patients Registry</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Appointments</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('receptionist/appointments') ? 'active' : '' }}" href="{{ route('receptionist.appointments') }}"><i class="fa-solid fa-calendar-check me-2 text-primary"></i> Manage Appointments</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Doctors</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('receptionist/doctors') ? 'active' : '' }}" href="{{ route('receptionist.doctors') }}"><i class="fa-solid fa-user-doctor me-2 text-info"></i> Doctor Directory</a>
                </li>
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('receptionist/profile') ? 'active' : '' }}" href="{{ route('receptionist.profile') }}"><i class="fa-solid fa-user-circle me-2 text-primary"></i> My Profile</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('receptionist/password') ? 'active' : '' }}" href="{{ route('receptionist.password') }}"><i class="fa-solid fa-key me-2 text-danger"></i> Change Password</a>
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-plus me-2"></i> Book Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-check me-2"></i> My Appointments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-history me-2"></i> Appointment History</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-shop me-2"></i> Shop Products</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping me-2"></i> My Cart</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-bag-shopping me-2"></i> Checkout</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-box me-2"></i> My Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-truck me-2"></i> Order Tracking</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-prescription me-2"></i> My Prescriptions</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-download me-2"></i> Download Prescription</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-notes-medical me-2"></i> Medical History</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-flask-vial me-2"></i> Lab Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Receipts & Invoices</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-pdf me-2"></i> Download PDF Receipt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-credit-card me-2"></i> Make Payment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-money-check-dollar me-2"></i> Payment History</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-comments me-2"></i> Chat with Doctor</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-bell me-2"></i> Notifications</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-pen me-2"></i> Edit Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-phone-flip me-2"></i> Emergency Contacts</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-shield-heart me-2"></i> Insurance Info</a>
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
        z-index: 1050;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 4px 0 10px rgba(0,0,0,0.05);
    }
    .sidebar-menu::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-menu::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .nav-link {
        color: #475569;
        font-weight: 500;
        padding: 0.8rem 1rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    .nav-link:hover {
        background: #f1f5f9;
        color: #166534;
        transform: translateX(5px);
    }
    .nav-link.active {
        background: #166534;
        color: white;
        box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
    }
    .nav-link.active i {
        color: white;
    }
    .nav-link i {
        width: 24px;
        text-align: center;
        color: #64748b;
        font-size: 1.1rem;
    }
    @media (max-width: 991.98px) {
        .sidebar {
            left: -260px;
        }
        .sidebar.active {
            left: 0;
        }
    }
</style>
