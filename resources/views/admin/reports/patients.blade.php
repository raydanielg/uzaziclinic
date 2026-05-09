@extends('layouts.admin')

@section('page_title', 'Patient Analytics')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-users text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Patients</p>
                    <h4 class="fw-bold mb-0">{{ $totalPatients ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-plus text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">New This Month</p>
                    <h4 class="fw-bold mb-0">{{ $newPatients ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-check text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Active Patients</p>
                    <h4 class="fw-bold mb-0">{{ $activePatients ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Patients by Gender</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Gender</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byGender ?? [] as $row)
                        <tr>
                            <td>{{ ucfirst($row->gender ?? 'Unknown') }}</td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $totalPatients > 0 ? round(($row->total / $totalPatients) * 100, 1) : 0 }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No data available</td>
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
                <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-list me-2"></i> View All Patients
                </a>
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
