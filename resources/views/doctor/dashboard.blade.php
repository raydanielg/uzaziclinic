@extends('layouts.app')

@section('content')
<div class="doctor-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Doctor Dashboard</h1>
                <p class="text-muted">Karibu Daktari {{ Auth::user()->name }}. Hapa kuna muhtasari wa wagonjwa na miadi yako leo.</p>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-calendar-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Miadi ya Leo</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-hospital-user fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Wagonjwa Wangu</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Pending Reviews</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_reviews'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 text-white" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 p-3 rounded-4 me-3">
                            <i class="fa-solid fa-chart-line fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 small fw-bold text-uppercase ls-1">Performance</h6>
                            <h3 class="mb-0 fw-bold">94%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Appointments -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-clock me-2 text-primary"></i>Recent Appointments</h5>
                        <a href="{{ route('doctor.schedule') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3">View Schedule</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Time</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_appointments as $appointment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fa-solid fa-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $appointment->user->name ?? 'N/A' }}</div>
                                                    <div class="small text-muted">ID: #{{ $appointment->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i A') }}</div>
                                            <div class="small text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = match($appointment->status) {
                                                    'completed' => 'bg-success-subtle text-success',
                                                    'pending' => 'bg-warning-subtle text-warning',
                                                    'cancelled' => 'bg-danger-subtle text-danger',
                                                    default => 'bg-primary-subtle text-primary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ ucfirst($appointment->status) }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light rounded-1 border-0" data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-1">
                                                    <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-eye me-2"></i> View Details</a></li>
                                                    <li><a class="dropdown-item small" href="{{ route('doctor.prescriptions.add') }}"><i class="fa-solid fa-file-medical me-2 text-info"></i> Write Prescription</a></li>
                                                    <li><a class="dropdown-item small" href="{{ route('doctor.lab.requests') }}"><i class="fa-solid fa-flask me-2 text-warning"></i> Request Lab Test</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item small text-success" href="#"><i class="fa-solid fa-check me-2"></i> Mark Completed</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center py-5">
                                        <td colspan="4" class="text-muted py-5">
                                            <i class="fa-solid fa-calendar-xmark fs-1 opacity-25 mb-3 d-block"></i>
                                            Hakuna miadi kwa sasa.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Tools -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-warning"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('doctor.prescriptions.add') }}" class="btn btn-light rounded-1 w-100 py-3 border-light shadow-none">
                                    <i class="fa-solid fa-file-prescription fs-4 text-info mb-2 d-block"></i>
                                    <span class="small fw-bold">Prescription</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('doctor.lab.requests') }}" class="btn btn-light rounded-1 w-100 py-3 border-light shadow-none">
                                    <i class="fa-solid fa-microscope fs-4 text-warning mb-2 d-block"></i>
                                    <span class="small fw-bold">Lab Test</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('doctor.medical.records') }}" class="btn btn-light rounded-1 w-100 py-3 border-light shadow-none">
                                    <i class="fa-solid fa-notes-medical fs-4 text-primary mb-2 d-block"></i>
                                    <span class="small fw-bold">Records</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('doctor.chat') }}" class="btn btn-light rounded-1 w-100 py-3 border-light shadow-none">
                                    <i class="fa-solid fa-comments fs-4 text-success mb-2 d-block"></i>
                                    <span class="small fw-bold">Chat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary p-4 text-white">
                        <h6 class="small text-uppercase opacity-75 fw-bold mb-3 ls-1">Schedule Outlook</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">8 Appointments</h3>
                                <p class="small mb-0 opacity-75">Scheduled for Tomorrow</p>
                            </div>
                            <i class="fa-solid fa-calendar-day fs-1 opacity-25"></i>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-4 py-3 border-0">
                                <div class="small text-muted mb-1">08:00 AM - 09:00 AM</div>
                                <div class="fw-bold small">Surgery Consultation</div>
                            </div>
                            <div class="list-group-item px-4 py-3 border-light bg-light">
                                <div class="small text-muted mb-1">10:30 AM - 11:00 AM</div>
                                <div class="fw-bold small">Follow-up: Sarah J.</div>
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
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
