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
        <div class="sidebar-brand mb-2">
            @if($roleName == 'admin')
                <i class="fa-solid fa-user-shield fa-2xl text-warning sidebar-logo-icon"></i>
            @else
                <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid sidebar-logo-img" style="max-height: 45px;">
            @endif
        </div>
        <h6 class="mb-0 fw-bold tracking-wider text-uppercase sidebar-brand-text">{{ $roleName == 'admin' ? 'Super Admin' : $roleName }}</h6>
        <small class="text-uppercase opacity-50 small sidebar-brand-sub" style="font-size: 0.6rem;">{{ $roleName == 'admin' ? 'System Controller' : 'Panel' }}</small>
    </div>
    
    <!-- Floating Collapse Toggle -->
    <button class="btn btn-sm sidebar-toggle-float d-none d-lg-flex" id="sidebarCollapse" title="Toggle Sidebar">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    
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
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/hr*') ? 'active' : '' }}" href="{{ route('admin.hr.index') }}">
                        <i class="fa-solid fa-users me-2 text-warning"></i> Human Resources (HR)
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
                    <a class="nav-link {{ Request::is('admin/pharmacy*') ? 'active' : '' }}" href="{{ route('admin.pharmacy.stock') }}">
                        <i class="fa-solid fa-pills me-2 text-success"></i> Pharmacy & Inventory
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

                {{-- Lab & Diagnostics --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Lab & Diagnostics</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/lab*') ? 'active' : '' }}" href="{{ route('admin.lab.catalog') }}">
                        <i class="fa-solid fa-microscope me-2 text-primary"></i> Lab Management
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/test-types*') ? 'active' : '' }}" href="{{ route('admin.test-types.index') }}">
                        <i class="fa-solid fa-vial me-2 text-warning"></i> Test Types
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/lab/results') ? 'active' : '' }}" href="{{ route('admin.lab.results') }}">
                        <i class="fa-solid fa-vial-circle-check me-2 text-success"></i> Test Results
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/lab/equipment') ? 'active' : '' }}" href="{{ route('admin.lab.equipment') }}">
                        <i class="fa-solid fa-flask me-2 text-info"></i> Lab Equipment
                    </a>
                </li>

                {{-- Content Management --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Content Management</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/blog*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
                        <i class="fa-solid fa-newspaper me-2 text-info"></i> Blog Management
                    </a>
                </li>

                {{-- Communications --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Communications</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/notifications/send') ? 'active' : '' }}" href="{{ route('admin.notifications.send') }}">
                        <i class="fa-solid fa-paper-plane me-2 text-primary"></i> Send Notification
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/notifications/history') ? 'active' : '' }}" href="{{ route('admin.notifications.history') }}">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-info"></i> Notification History
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/notifications/email*') ? 'active' : '' }}" href="{{ route('admin.notifications.emailTemplates') }}">
                        <i class="fa-solid fa-envelope-open-text me-2 text-warning"></i> Email Templates
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/notifications/sms*') ? 'active' : '' }}" href="{{ route('admin.notifications.smsTemplates') }}">
                        <i class="fa-solid fa-message me-2 text-success"></i> SMS Templates
                    </a>
                </li>

                {{-- Reports --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Reports</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/reports/sales') ? 'active' : '' }}" href="{{ route('admin.reports.sales') }}">
                        <i class="fa-solid fa-chart-pie me-2 text-primary"></i> Sales Report
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/reports/patients') ? 'active' : '' }}" href="{{ route('admin.reports.patients') }}">
                        <i class="fa-solid fa-users me-2 text-info"></i> Patient Report
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/reports/doctors') ? 'active' : '' }}" href="{{ route('admin.reports.doctors') }}">
                        <i class="fa-solid fa-user-doctor me-2 text-success"></i> Doctor Performance
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/reports/stock') ? 'active' : '' }}" href="{{ route('admin.reports.stock') }}">
                        <i class="fa-solid fa-boxes-stacked me-2 text-warning"></i> Stock Report
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/reports/revenue') ? 'active' : '' }}" href="{{ route('admin.reports.revenue') }}">
                        <i class="fa-solid fa-money-bill-wave me-2 text-success"></i> Revenue Report
                    </a>
                </li>

                {{-- System Health --}}
                <li class="nav-item-header mt-4 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">System Health</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/analytics*') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                        <i class="fa-solid fa-chart-line me-2 text-warning"></i> Platform Analytics
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}" href="{{ route('admin.users.logs') }}">
                        <i class="fa-solid fa-shield-virus me-2 text-danger"></i> Security Audit Logs
                    </a>
                </li>

                {{-- System Settings --}}
                <li class="nav-item-header mt-4 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">System Settings</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/settings/general') ? 'active' : '' }}" href="{{ route('admin.settings.general') }}">
                        <i class="fa-solid fa-gear me-2 text-primary"></i> General Settings
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/settings/email') ? 'active' : '' }}" href="{{ route('admin.settings.email') }}">
                        <i class="fa-solid fa-envelope me-2 text-info"></i> Email Config
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/settings/sms') ? 'active' : '' }}" href="{{ route('admin.settings.sms') }}">
                        <i class="fa-solid fa-comment-sms me-2 text-success"></i> SMS Gateway
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('admin/settings/gateways') ? 'active' : '' }}" href="{{ route('admin.settings.gateways') }}">
                        <i class="fa-solid fa-credit-card me-2 text-warning"></i> Payment Gateways
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem; letter-spacing: 1px;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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

                {{-- Patients --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Patients</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/consultation') ? 'active' : '' }}" href="{{ route('doctor.consultation.queue') }}">
                        <i class="fa-solid fa-user-doctor me-2 text-success"></i> My Consultation Queue
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/patients*') ? 'active' : '' }}" href="{{ route('doctor.patients') }}">
                        <i class="fa-solid fa-hospital-user me-2 text-success"></i> My Patients
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/schedule*') ? 'active' : '' }}" href="{{ route('doctor.schedule') }}">
                        <i class="fa-solid fa-calendar-days me-2 text-info"></i> My Schedule
                    </a>
                </li>

                {{-- Treatment --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Treatment</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/prescriptions*') ? 'active' : '' }}" href="{{ route('doctor.prescriptions.add') }}">
                        <i class="fa-solid fa-file-medical me-2 text-info"></i> Write Prescription
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/lab-requests*') ? 'active' : '' }}" href="{{ route('doctor.lab.requests') }}">
                        <i class="fa-solid fa-flask-vial me-2 text-warning"></i> Request Lab Test
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/lab-results*') ? 'active' : '' }}" href="{{ route('doctor.lab.results') }}">
                        <i class="fa-solid fa-vial-circle-check me-2 text-success"></i> Lab Results
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/medical-records*') ? 'active' : '' }}" href="{{ route('doctor.medical.records') }}">
                        <i class="fa-solid fa-notes-medical me-2 text-primary"></i> Medical Records
                    </a>
                </li>

                {{-- Communication --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Communication</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/chat*') ? 'active' : '' }}" href="{{ route('doctor.chat') }}">
                        <i class="fa-solid fa-comments me-2 text-primary"></i> Chat with Patients
                    </a>
                </li>

                {{-- Reports & Account --}}
                <li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Reports & Account</li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/reports*') ? 'active' : '' }}" href="{{ route('doctor.reports') }}">
                        <i class="fa-solid fa-chart-line me-2 text-warning"></i> My Reports
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/profile*') ? 'active' : '' }}" href="{{ route('doctor.profile') }}">
                        <i class="fa-solid fa-user-circle me-2 text-secondary"></i> My Profile
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('doctor/password*') ? 'active' : '' }}" href="{{ route('doctor.password') }}">
                        <i class="fa-solid fa-key me-2 text-danger"></i> Change Password
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('doctor-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="doctor-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('nurse-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="nurse-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
                    <a class="nav-link {{ Request::is('pharmacist/dispense*') ? 'active' : '' }}" href="{{ route('pharmacist.dispense.index') }}">
                        <i class="fa-solid fa-pills me-2 text-danger"></i> Kutolea Dawa (Dispense)
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('pharmacist-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="pharmacist-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
                    <a class="nav-link {{ Request::is('lab/process') ? 'active' : '' }}" href="{{ route('lab.process.index') }}"><i class="fa-solid fa-flask me-2 text-danger"></i> Ombi la Majaribio (Process)</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ Request::is('lab/requests') ? 'active' : '' }}" href="{{ route('lab.requests') }}"><i class="fa-solid fa-list me-2 text-danger"></i> Lab Requests (Old)</a>
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('lab-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="lab-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('accountant-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="accountant-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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
                    <a class="nav-link {{ Request::is('receptionist/visits/queue') ? 'active' : '' }}" href="{{ route('receptionist.visits.queue') }}"><i class="fa-solid fa-users-line me-2 text-primary"></i> Foleni ya Wagonjwa</a>
                </li>
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('receptionist-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="receptionist-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
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

                {{-- Logout --}}
                <li class="nav-item-header mt-4 mb-2 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Session</li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-danger logout-sidebar-item" href="#" onclick="event.preventDefault(); document.getElementById('patient-logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2 text-danger"></i>
                        <span class="fw-bold">Logout</span>
                    </a>
                    <form id="patient-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
        </ul>
    </div>
</div>

<style>
    .sidebar {
        width: 270px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        z-index: 1050;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 4px 0 24px rgba(0,0,0,0.06);
        border-right: 1px solid rgba(226,232,240,0.6);
    }
    .sidebar-header {
        background: linear-gradient(135deg, #0f4c3a 0%, #166534 50%, #15803d 100%) !important;
        position: relative;
        overflow: hidden;
    }
    .sidebar-header::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .sidebar-header::before {
        content: '';
        position: absolute;
        bottom: -20px;
        left: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .sidebar-menu::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-menu::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-menu::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .nav-item-header {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem 0.4rem;
        margin-top: 0.75rem !important;
        font-size: 0.68rem !important;
        font-weight: 700 !important;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #94a3b8;
    }
    .nav-item-header::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 2px;
        background: #10b981;
    }
    .nav-link {
        color: #475569;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        white-space: nowrap;
        margin-bottom: 3px;
        position: relative;
        overflow: hidden;
    }
    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #10b981;
        border-radius: 0 4px 4px 0;
        transform: scaleY(0);
        transition: transform 0.25s ease;
    }
    .nav-link:hover {
        background: linear-gradient(90deg, #ecfdf5 0%, #f0fdf4 100%);
        color: #166534;
        transform: translateX(6px);
    }
    .nav-link:hover::before {
        transform: scaleY(1);
    }
    .nav-link.active {
        background: linear-gradient(90deg, #166534 0%, #15803d 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(22, 101, 52, 0.28);
        transform: translateX(4px);
    }
    .nav-link.active::before {
        transform: scaleY(1);
        background: #fbbf24;
    }
    .nav-link.active i {
        color: #fbbf24 !important;
    }
    .nav-link i {
        width: 26px;
        text-align: center;
        color: #64748b;
        font-size: 1rem;
        transition: color 0.2s;
    }
    .nav-link:hover i {
        color: #166534;
    }
    .nav-item {
        position: relative;
    }
    .logout-sidebar-item {
        background: linear-gradient(90deg, #fef2f2 0%, #fff5f5 100%) !important;
        border: 1px solid rgba(220,38,38,0.12) !important;
        border-radius: 12px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative;
        overflow: hidden;
    }
    .logout-sidebar-item::after {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: #ef4444;
        border-radius: 0 4px 4px 0;
        transform: scaleY(0);
        transition: transform 0.25s ease;
    }
    .logout-sidebar-item:hover {
        background: linear-gradient(90deg, #fee2e2 0%, #fef2f2 100%) !important;
        border-color: rgba(220,38,38,0.25) !important;
        transform: translateX(6px) !important;
        box-shadow: 0 4px 16px rgba(220,38,38,0.12);
    }
    .logout-sidebar-item:hover::after {
        transform: scaleY(1);
    }
    .logout-sidebar-item:hover i {
        animation: pulse-red 1.2s infinite;
    }
    @keyframes pulse-red {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.15); opacity: 0.8; }
    }
    /* Collapsed Sidebar */
    .sidebar.collapsed {
        width: 72px;
    }
    .sidebar.collapsed .sidebar-brand-text,
    .sidebar.collapsed .sidebar-brand-sub,
    .sidebar.collapsed .nav-item-header {
        display: none !important;
    }
    .sidebar.collapsed .nav-link {
        font-size: 0;
    }
    .sidebar.collapsed .nav-link i {
        font-size: 1.2rem;
    }
    .sidebar.collapsed .sidebar-header {
        padding: 1rem 0.25rem !important;
        min-height: 70px;
    }
    .sidebar.collapsed .sidebar-brand {
        margin-bottom: 0 !important;
    }
    .sidebar.collapsed .sidebar-logo-img {
        max-height: 32px;
    }
    .sidebar.collapsed .sidebar-logo-icon {
        font-size: 1.5rem;
    }
    .sidebar.collapsed .sidebar-menu {
        padding: 0.75rem 0.4rem !important;
    }
    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.8rem 0.3rem;
        border-radius: 14px;
        margin-bottom: 4px;
    }
    .sidebar.collapsed .nav-link i {
        width: auto;
        margin-right: 0 !important;
        font-size: 1.2rem;
    }
    .sidebar.collapsed .logout-sidebar-item {
        justify-content: center;
        padding: 0.7rem 0.3rem;
    }
    .sidebar.collapsed .sidebar-toggle-float {
        right: -14px;
    }
    .sidebar.collapsed .sidebar-toggle-float i {
        transform: rotate(180deg);
    }
    .sidebar.collapsed .nav-link::before,
    .sidebar.collapsed .logout-sidebar-item::after {
        display: none;
    }
    .sidebar.collapsed .nav-link:hover,
    .sidebar.collapsed .logout-sidebar-item:hover {
        transform: scale(1.12) !important;
        background: linear-gradient(135deg, #166534 0%, #15803d 100%) !important;
        color: white !important;
    }
    .sidebar.collapsed .nav-link:hover i {
        color: #fbbf24 !important;
    }
    .sidebar.collapsed .nav-link.active:hover {
        background: linear-gradient(135deg, #166534 0%, #15803d 100%) !important;
    }
    /* Floating Toggle Button */
    .sidebar-toggle-float {
        position: absolute;
        right: -14px;
        top: 84px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #166534 0%, #15803d 100%);
        color: white;
        border: 2px solid white;
        box-shadow: 0 4px 12px rgba(22,101,52,0.3);
        align-items: center;
        justify-content: center;
        padding: 0;
        z-index: 1060;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sidebar-toggle-float:hover {
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(22,101,52,0.4);
    }
    .sidebar-toggle-float i {
        font-size: 0.7rem;
        transition: transform 0.3s ease;
    }
    /* Custom tooltip for collapsed sidebar */
    .sidebar.collapsed .nav-link[data-bs-toggle="tooltip"] {
        position: relative;
    }
    .tooltip .tooltip-inner {
        background: linear-gradient(135deg, #166534 0%, #15803d 100%);
        font-weight: 600;
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .tooltip.bs-tooltip-end .tooltip-arrow::before {
        border-right-color: #166534;
    }
    @media (max-width: 991.98px) {
        .sidebar {
            left: -270px;
        }
        .sidebar.active {
            left: 0;
        }
    }
    /* Smooth main content transition */
    .main-content {
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const collapseBtn = document.getElementById('sidebarCollapse');
        const mainContent = document.querySelector('.main-content');

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        function updateTooltips() {
            // Remove old tooltips
            document.querySelectorAll('.nav-link[data-bs-toggle="tooltip"]').forEach(el => {
                const t = bootstrap.Tooltip.getInstance(el);
                if (t) t.dispose();
            });
            
            // Add tooltips when collapsed
            if (sidebar.classList.contains('collapsed')) {
                document.querySelectorAll('.nav-link').forEach(function(el) {
                    const text = el.querySelector('span') ? el.querySelector('span').textContent.trim() : el.textContent.trim();
                    if (text) {
                        el.setAttribute('data-bs-toggle', 'tooltip');
                        el.setAttribute('data-bs-placement', 'right');
                        el.setAttribute('title', text);
                        new bootstrap.Tooltip(el);
                    }
                });
            } else {
                document.querySelectorAll('.nav-link[data-bs-toggle="tooltip"]').forEach(function(el) {
                    el.removeAttribute('data-bs-toggle');
                    el.removeAttribute('data-bs-placement');
                    el.removeAttribute('title');
                });
            }
        }

        if (collapseBtn && sidebar) {
            collapseBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                if (mainContent) {
                    mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '72px' : '270px';
                }
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                updateTooltips();
            });

            // Restore state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                if (mainContent) mainContent.style.marginLeft = '72px';
                updateTooltips();
            }
        }

        // Mobile sidebar close
        const closeBtn = document.getElementById('sidebarClose');
        if (closeBtn && sidebar) {
            closeBtn.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
        }
    });
</script>
