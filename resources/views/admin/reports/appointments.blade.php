@extends('layouts.admin')

@section('page_title', 'Appointment Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-check text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Appointments</p>
                    <h4 class="fw-bold mb-0">{{ $totalAppointments ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-day text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">This Month</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $thisMonth ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-check-double text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Completed</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $completed ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-danger-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-xmark text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Cancelled</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $cancelled ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-1 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Status Breakdown</h5>
                    <p class="text-muted small mb-0">Current status of all scheduled appointments</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">STATUS</th>
                            <th class="border-0">TOTAL</th>
                            <th class="border-0">PERCENTAGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byStatus as $stat)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-dark text-uppercase small ls-1">{{ $stat->status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border-0 rounded-1 px-2 py-1 fw-bold">{{ $stat->total }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                        @php $perc = $totalAppointments > 0 ? ($stat->total / $totalAppointments) * 100 : 0; @endphp
                                        <div class="progress-bar bg-primary" style="width: {{ $perc }}%"></div>
                                    </div>
                                    <span class="small fw-bold text-muted">{{ round($perc, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-calendar me-2"></i> View All Appointments
                </a>
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
