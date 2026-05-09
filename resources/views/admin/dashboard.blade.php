@extends('layouts.app')

@section('content')
<div class="admin-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Admin Dashboard</h1>
                <p class="text-muted">Karibu tena, hapa kuna muhtasari wa mfumo wako.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-primary-soft text-primary me-3">
                                <i class="fa-solid fa-user-injured fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Total Patients</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h2>
                            <div class="text-success small fw-bold">
                                <i class="fa-solid fa-arrow-up me-1"></i>+4%
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-success-soft text-success me-3">
                                <i class="fa-solid fa-user-doctor fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Total Doctors</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_doctors'] }}</h2>
                            <div class="text-success small fw-bold">
                                <i class="fa-solid fa-arrow-up me-1"></i>+2%
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 45%"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-warning-soft text-warning me-3">
                                <i class="fa-solid fa-calendar-check fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Today Appointments</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h2>
                            <div class="text-danger small fw-bold">
                                <i class="fa-solid fa-arrow-down me-1"></i>-1%
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-info-soft text-info me-3">
                                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Pending Orders</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['pending_orders'] }}</h2>
                            <div class="text-success small fw-bold">
                                <i class="fa-solid fa-arrow-up me-1"></i>+8%
                            </div>
                        </div>
                    </div>
                    <div class="progress rounded-0" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Appointments -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold">Recent Appointments</h5>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light text-primary fw-bold">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Patient</th>
                                        <th>Doctor</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center py-5">
                                        <td colspan="5" class="text-muted">Hakuna miadi kwa sasa.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access Menu -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Quick Actions</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('admin.users.create') }}" class="quick-action-btn">
                                    <i class="fa-solid fa-user-plus d-block mb-2 text-primary fa-xl"></i>
                                    <span>Add User</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.patients.create') }}" class="quick-action-btn">
                                    <i class="fa-solid fa-heart-pulse d-block mb-2 text-success fa-xl"></i>
                                    <span>Add Patient</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                                    <i class="fa-solid fa-box-open d-block mb-2 text-warning fa-xl"></i>
                                    <span>Add Product</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.settings.general') }}" class="quick-action-btn">
                                    <i class="fa-solid fa-gear d-block mb-2 text-info fa-xl"></i>
                                    <span>Settings</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item border-start border-2 ps-3 pb-3">
                                <div class="timeline-point bg-primary shadow-sm"></div>
                                <div class="small text-muted mb-1">Leo, 10:30 AM</div>
                                <div class="fw-bold small">Admin mpya ameongezwa</div>
                            </div>
                            <div class="timeline-item border-start border-2 ps-3 pb-3">
                                <div class="timeline-point bg-success shadow-sm"></div>
                                <div class="small text-muted mb-1">Leo, 09:15 AM</div>
                                <div class="fw-bold small">Stock ya dawa imesasishwa</div>
                            </div>
                            <div class="timeline-item border-start border-2 ps-3">
                                <div class="timeline-point bg-warning shadow-sm"></div>
                                <div class="small text-muted mb-1">Jana, 04:45 PM</div>
                                <div class="fw-bold small">Malipo ya bima yameidhinishwa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-card {
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }

    .quick-action-btn {
        display: block;
        padding: 1.25rem;
        background-color: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        color: #475569;
        text-align: center;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .quick-action-btn:hover {
        background-color: #fff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        color: #1e293b;
    }
    .quick-action-btn span {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .timeline-item {
        position: relative;
    }
    .timeline-point {
        position: absolute;
        left: -5px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
</style>
@endsection
