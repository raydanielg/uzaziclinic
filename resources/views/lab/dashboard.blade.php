@extends('layouts.app')

@section('content')
<div class="lab-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Lab Technician Dashboard</h1>
                <p class="text-muted small">Welcome, {{ Auth::user()->name }}. Manage laboratory tests and equipment.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-flask-vial fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Pending</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_requests'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-spinner fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Processing</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['processing_requests'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-check-double fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Done Today</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['completed_today'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3">
                            <i class="fa-solid fa-microscope fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Lab Tests</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_tests'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-list-check me-2 text-primary"></i>Pending Lab Requests</h5>
                        <a href="{{ route('lab.requests') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3 border-0">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Requested By</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Tests</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pending_samples as $sample)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $sample->patient->name ?? 'N/A' }}</div>
                                            <div class="small text-muted">ID: #PT-{{ $sample->patient_id }}</div>
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark">Dr. {{ $sample->doctor->name ?? 'N/A' }}</div>
                                        </td>
                                        <td><span class="badge bg-primary-subtle text-primary rounded-1">{{ $sample->test_names }}</span></td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-primary rounded-1 px-3 fw-bold border-0">Process</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No pending requests.</td>
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
