@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="receptionist-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#1e3a5f 0%,#0e7490 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-hospital"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-person-desk"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Karani wa Mapokezi</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Miadi leo: <strong>{{ $stats['today_appointments'] }}</strong> &bull; Wagonjwa wapya: <strong>{{ $stats['pending_registrations'] }}</strong></p>
                </div>
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
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="bg-dark p-4 text-white">
                        <h6 class="small text-uppercase opacity-75 fw-bold mb-2">Today's Overview</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['today_appointments'] }} Appointments</h3>
                        <p class="small mb-0 opacity-75">{{ $stats['total_patients'] }} Total Patients Registered</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('receptionist.appointments') }}" class="btn btn-primary rounded-1 py-2 text-start ps-3 border-0 fw-bold">
                                <i class="fa-solid fa-calendar-check me-2"></i> View Appointments
                            </a>
                            <a href="{{ route('receptionist.patients') }}" class="btn btn-success rounded-1 py-2 text-start ps-3 border-0 fw-bold text-white">
                                <i class="fa-solid fa-users me-2"></i> Patient List
                            </a>
                            <a href="{{ route('receptionist.doctors') }}" class="btn btn-outline-secondary rounded-1 py-2 text-start ps-3 border-0">
                                <i class="fa-solid fa-user-doctor me-2"></i> Doctor Directory
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase">Stats Summary</h6>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="small text-muted">New Patients Today</span>
                        <span class="badge bg-success-subtle text-success fw-bold">{{ $stats['pending_registrations'] }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2">
                        <span class="small text-muted">Active Doctors</span>
                        <span class="badge bg-info-subtle text-info fw-bold">{{ $stats['active_doctors'] }}</span>
                    </div>
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
