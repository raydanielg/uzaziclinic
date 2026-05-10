@extends('layouts.admin')

@section('page_title', 'Communications & Notifications')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <!-- Sidebar Menu -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Notification Center</h6>
            </div>
            <div class="list-group list-group-flush notification-nav">
                <a href="{{ route('admin.notifications.send') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.notifications.send') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-paper-plane me-2"></i> Send Notification
                </a>
                <a href="{{ route('admin.notifications.history') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.notifications.history') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> History
                </a>
                <a href="{{ route('admin.notifications.emailTemplates') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.notifications.emailTemplates') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-envelope-open-text me-2"></i> Email Templates
                </a>
                <a href="{{ route('admin.notifications.smsTemplates') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.notifications.smsTemplates') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-message me-2"></i> SMS Templates
                </a>
            </div>
        </div>
        
        <!-- Stats Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4 mb-4">
            <h6 class="small text-uppercase opacity-75 fw-bold mb-3">Today's Broadcasts</h6>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h2 class="fw-bold mb-0">124</h2>
                    <p class="small mb-0 opacity-75">Messages delivered</p>
                </div>
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="fa-solid fa-paper-plane fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">@yield('notification_title', 'Send New Broadcast')</h5>
                    <p class="text-muted small mb-0">@yield('notification_subtitle', 'Communicate with your patients and staff instantly')</p>
                </div>
            </div>

            @yield('notification_content')
        </div>
    </div>
</div>

<style>
    .notification-nav .list-group-item {
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .notification-nav .list-group-item:hover:not(.active) {
        background-color: #f8fafc;
        color: var(--bs-primary);
    }
    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
    }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
