@extends('layouts.app')

@section('content')
<div class="doctor-schedule py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">My Schedule & Appointments</h4>
                <p class="text-muted small">Manage your daily appointments and availability</p>
            </div>
            <div class="btn-group rounded-1 shadow-sm">
                <button class="btn btn-white border-light active text-primary fw-bold px-4">Today</button>
                <button class="btn btn-white border-light text-muted px-4">Weekly</button>
                <button class="btn btn-white border-light text-muted px-4">Monthly</button>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Calendar/Today's Timeline -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>Today's Timeline</h5>
                        <span class="badge bg-primary-subtle text-primary px-3 rounded-pill">{{ now()->format('M d, Y') }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="timeline-container p-4">
                            @forelse($appointments as $app)
                            <div class="d-flex mb-4 timeline-item">
                                <div class="time-column text-end me-4" style="min-width: 80px;">
                                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i') }}</div>
                                    <small class="text-muted text-uppercase" style="font-size: 0.6rem;">{{ \Carbon\Carbon::parse($app->appointment_date)->format('A') }}</small>
                                </div>
                                <div class="content-column flex-grow-1 border-start border-primary border-4 ps-4 pb-3">
                                    <div class="card border-0 bg-light rounded-1 p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold mb-1 text-dark">{{ $app->user->name ?? 'N/A' }}</h6>
                                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 small">Regular Checkup</span>
                                            </div>
                                            @php
                                                $statusClass = match($app->status) {
                                                    'completed' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-primary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} rounded-pill px-3">{{ ucfirst($app->status) }}</span>
                                        </div>
                                        <div class="d-flex gap-3 text-muted small">
                                            <span><i class="fa-solid fa-phone me-1"></i> {{ $app->user->phone ?? 'N/A' }}</span>
                                            <span><i class="fa-solid fa-id-card me-1"></i> #PT-{{ $app->user->id ?? '000' }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('doctor.patients.details', $app->user->id ?? 0) }}" class="btn btn-sm btn-primary rounded-1 px-3 fw-bold">Open File</a>
                                            <button class="btn btn-sm btn-outline-secondary rounded-1 px-3 ms-1">Reschedule</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-calendar-check fs-1 opacity-25 mb-3 d-block"></i>
                                No appointments scheduled for today.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Stats & Settings -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Schedule Stats</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-1 text-center border border-primary border-opacity-10">
                                <div class="small text-muted mb-1">Total</div>
                                <div class="h4 fw-bold text-primary mb-0">{{ $appointments->count() }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-success bg-opacity-10 rounded-1 text-center border border-success border-opacity-10">
                                <div class="small text-muted mb-1">Done</div>
                                <div class="h4 fw-bold text-success mb-0">{{ $appointments->where('status', 'completed')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0 small text-uppercase ls-1">Availability Status</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked id="availabilitySwitch">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                        <div class="fw-bold">Currently Available</div>
                    </div>
                    <p class="small text-muted mb-0">You are accepting new appointments and emergency requests.</p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Working Hours</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted">Mon - Fri</span>
                            <span class="fw-bold">08:00 AM - 05:00 PM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-light">
                            <span class="text-muted">Saturday</span>
                            <span class="fw-bold">09:00 AM - 01:00 PM</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-light">
                            <span class="text-muted">Sunday</span>
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2">OFF</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .timeline-item:last-child .content-column {
        border-start-color: transparent !important;
    }
    .btn-white { background: white; }
    .btn-white:hover { background: #f8fafc; }
</style>
@endsection
