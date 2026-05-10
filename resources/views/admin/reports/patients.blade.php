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
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-plus text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">New (This Month)</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $newPatients ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-check text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Active Patients</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $activePatients ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-venus-mars text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Genders</p>
                    <h4 class="fw-bold mb-0 text-dark small">{{ $byGender->count() }} Types</h4>
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
                    <h5 class="fw-bold mb-0 text-dark">Gender Distribution</h5>
                    <p class="text-muted small mb-0">Patient breakdown by gender</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">GENDER</th>
                            <th class="border-0">COUNT</th>
                            <th class="border-0">PERCENTAGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byGender as $gender)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-dark text-uppercase small ls-1">{{ $gender->gender ?: 'Not Specified' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border-0 rounded-1 px-2 py-1 fw-bold">{{ $gender->total }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $totalPatients > 0 ? ($gender->total / $totalPatients) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="small fw-bold text-muted">{{ $totalPatients > 0 ? round(($gender->total / $totalPatients) * 100, 1) : 0 }}%</span>
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
