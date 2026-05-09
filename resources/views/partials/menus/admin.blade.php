{{-- 1. Appointments Section --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Appointments</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/appointments/book') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-calendar-plus me-2 text-primary"></i> Book Appointment
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/appointments/upcoming') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-calendar-check me-2 text-success"></i> Upcoming Appointments
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/appointments/history') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-clock-rotate-left me-2 text-info"></i> Appointment History
    </a>
</li>

{{-- 2. Shop / Store Section --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Shop / Store</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-box-open me-2 text-warning"></i> All Products
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-cart-shopping me-2 text-danger"></i> My Orders
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/tracking*') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-truck me-2 text-info"></i> Order Tracking
    </a>
</li>

{{-- 3. Medical Services --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Medical Services</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/medical/prescriptions*') ? 'active' : '' }}" href="{{ route('admin.medical.prescriptions') }}">
        <i class="fa-solid fa-file-prescription me-2 text-success"></i> My Prescriptions
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/medical/records*') ? 'active' : '' }}" href="{{ route('admin.medical.records') }}">
        <i class="fa-solid fa-folder-tree me-2 text-primary"></i> Medical Records
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/medical/lab-results*') ? 'active' : '' }}" href="{{ route('admin.medical.lab-results') }}">
        <i class="fa-solid fa-flask-vial me-2 text-warning"></i> Lab Results
    </a>
</li>

{{-- 4. Payments & Billing --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Payments & Billing</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/finance/receipts*') ? 'active' : '' }}" href="{{ route('admin.finance.receipts') }}">
        <i class="fa-solid fa-file-invoice-dollar me-2 text-danger"></i> Receipts & Invoices
    </a>
</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/finance/history*') ? 'active' : '' }}" href="{{ route('admin.finance.history') }}">
        <i class="fa-solid fa-credit-card me-2 text-success"></i> Payment History
    </a>
</li>

{{-- 5. Communication & Insurance --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Communication & Insurance</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/communication/chat*') ? 'active' : '' }}" href="{{ route('admin.communication.chat') }}">
        <i class="fa-solid fa-comments me-2 text-primary"></i> Chat with Doctor
    </a>
</li>
<li class="nav-item-header mt-2 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Insurance</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/insurance*') ? 'active' : '' }}" href="{{ route('admin.insurance.index') }}">
        <i class="fa-solid fa-shield-heart me-2 text-danger"></i> My Insurance Info
    </a>
</li>

{{-- 6. Settings --}}
<li class="nav-item-header mt-3 mb-1 small text-muted text-uppercase fw-bold px-3" style="font-size: 0.65rem;">Settings</li>
<li class="nav-item mb-1">
    <a class="nav-link {{ Request::is('admin/profile*') ? 'active' : '' }}" href="#">
        <i class="fa-solid fa-user-gear me-2 text-secondary"></i> My Profile
    </a>
</li>
