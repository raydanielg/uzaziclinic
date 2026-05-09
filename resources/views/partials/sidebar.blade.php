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
            {{-- 1. ADMIN MENU --}}
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
                    <a class="nav-link {{ Request::is('admin/store*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-day me-2"></i> Today's Tests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-clock me-2"></i> Pending Tests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-flask me-2"></i> All Lab Tests</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-plus-circle me-2"></i> Add New Test</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-tags me-2"></i> Test Categories</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-vial me-2"></i> Sample Collection</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-truck-ramp-box me-2"></i> Sample Tracking</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-pen-to-square me-2"></i> Enter Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-spinner me-2"></i> Pending Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-square-check me-2"></i> Completed Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-print me-2"></i> Print Results</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-microscope me-2"></i> Lab Equipment List</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-screwdriver-wrench me-2"></i> Maintenance Schedule</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-box-archive me-2"></i> Lab Consumables / Reagents</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-triangle-exclamation me-2"></i> Low Stock Alerts</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-pie me-2"></i> Reports (Test Volume/Revenue)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-lines me-2"></i> All Invoices</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-clock-rotate-left me-2"></i> Pending Payments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-circle-check me-2"></i> Paid Invoices</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-receipt me-2"></i> Generate Receipt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-box-archive me-2"></i> All Receipts</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-print me-2"></i> Print Receipt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-envelope-open-text me-2"></i> Email Receipt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-pdf me-2"></i> Download PDF Receipt</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-money-bill-transfer me-2"></i> Payments (Cash/Card/Etc)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-shield-heart me-2"></i> Insurance Management</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hand-holding-medical me-2"></i> Insurance Claims</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-wallet me-2"></i> Expenses Management</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-tags me-2"></i> Discounts & Promos</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-line me-2"></i> Financial Reports</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-pie me-2"></i> Profit & Loss Report</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-landmark me-2"></i> Tax Report</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
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
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-plus me-2"></i> Register New Patient</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-magnifying-glass me-2"></i> Search Patient</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-pen me-2"></i> Update Patient Info</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-plus me-2"></i> Book Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-check me-2"></i> Manage Appointments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-minus me-2"></i> Reschedule Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-calendar-xmark me-2"></i> Cancel Appointment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-print me-2"></i> Print Appointment Slip</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hospital-user me-2"></i> Today's Arrivals</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-check me-2"></i> Patient Check-in</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-minus me-2"></i> Patient Check-out</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-doctor me-2"></i> Available Doctors</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-hand-holding-hand me-2"></i> Assign Doctor</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-users-viewfinder me-2"></i> Doctor Queue</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-bed-pulse me-2"></i> Bed Assignment</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-file-invoice me-2"></i> View Invoices</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-receipt me-2"></i> Print Receipt (Basic)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-money-bill-wave me-2"></i> Collect Cash Payments</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-comment-sms me-2"></i> Send SMS Reminders</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-chart-line me-2"></i> Reports (Daily Visits)</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-user-circle me-2"></i> My Profile</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="fa-solid fa-key me-2"></i> Change Password</a>
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
