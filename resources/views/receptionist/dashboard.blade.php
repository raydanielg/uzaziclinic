@extends('layouts.app')

@section('content')
<div class="receptionist-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Receptionist Dashboard</h1>
                <p class="text-muted small">Welcome, {{ Auth::user()->name }}. Manage appointments and patient registrations.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-calendar-day fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Today's Appts</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-user-plus fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">New Patients</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_registrations'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3">
                            <i class="fa-solid fa-user-doctor fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Active Doctors</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['active_doctors'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-users fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Total Patients</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-clock-list me-2 text-primary"></i>Recent Appointments</h5>
                        <a href="{{ route('receptionist.appointments') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3 border-0">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Time</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_appointments as $app)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $app->user->name ?? 'N/A' }}</div>
                                            <div class="small text-muted">ID: #PT-{{ $app->user_id }}</div>
                                        </td>
                                        <td>Dr. {{ $app->doctor->name ?? 'N/A' }}</td>
                                        <td class="small text-muted">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i A') }}</td>
                                        <td class="text-end pe-4">
                                            <span class="badge bg-{{ $app->status == 'pending' ? 'warning' : 'success' }}-subtle text-{{ $app->status == 'pending' ? 'warning' : 'success' }} rounded-pill px-3">{{ ucfirst($app->status) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No recent appointments.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-success-soft text-success p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-users fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold">Wagonjwa</h5>
                    <p class="text-muted small">Orodha ya wagonjwa waliosajiliwa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-info-soft text-info p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-chart-pie fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold">Ripoti</h5>
                    <p class="text-muted small">Ripoti na muhtasari wa utendaji.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endsection
