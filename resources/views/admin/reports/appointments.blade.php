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
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-day text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">This Month</p>
                    <h4 class="fw-bold mb-0">{{ $thisMonth ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-check-circle text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Completed</p>
                    <h4 class="fw-bold mb-0">{{ $completed ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-danger-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-times-circle text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Cancelled</p>
                    <h4 class="fw-bold mb-0">{{ $cancelled ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Appointments by Status</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byStatus ?? [] as $row)
                        <tr>
                            <td><span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($row->status) }}</span></td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $totalAppointments > 0 ? round(($row->total / $totalAppointments) * 100, 1) : 0 }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No appointment data available</td>
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
