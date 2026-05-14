@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="lab-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#1e1b4b 0%,#4f46e5 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-microscope"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-flask-vial"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Mtaalamu wa Maabara</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Zinasubiri: <strong>{{ $stats['pending_requests'] }}</strong> &bull; Zimekamilika leo: <strong>{{ $stats['completed_today'] }}</strong></p>
                </div>
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
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Quick Tools</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('lab.requests') }}" class="btn btn-primary rounded-1 py-2 text-start ps-3 border-0 shadow-none">
                            <i class="fa-solid fa-vial me-2"></i> Manage Requests
                        </a>
                        <a href="{{ route('lab.equipment') }}" class="btn btn-info text-white rounded-1 py-2 text-start ps-3 border-0 shadow-none fw-bold">
                            <i class="fa-solid fa-microscope me-2"></i> Lab Equipment
                        </a>
                        <a href="{{ route('lab.tests') }}" class="btn btn-warning rounded-1 py-2 text-start ps-3 border-0 shadow-none fw-bold">
                            <i class="fa-solid fa-clipboard-list me-2"></i> Test Catalog
                        </a>
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
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
