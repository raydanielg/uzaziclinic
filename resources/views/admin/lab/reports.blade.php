@extends('layouts.admin')

@section('page_title', 'Laboratory Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-file-invoice text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Tests</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_tests'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clipboard-check text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Completed</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['completed'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clock-rotate-left text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pending</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['pending'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Lab Performance Reports</h5>
                    <p class="text-muted small mb-0">Overview of laboratory activities and test volumes</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light rounded-1 px-3 border shadow-sm small">
                        <i class="fa-solid fa-download me-2"></i> Export CSV
                    </button>
                    <button class="btn btn-primary rounded-1 px-3 shadow-sm border-0 small">
                        <i class="fa-solid fa-print me-2"></i> Print Report
                    </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="p-4 bg-light rounded-4 border border-dashed text-center py-5">
                        <i class="fa-solid fa-chart-line fs-1 text-muted opacity-25 mb-3"></i>
                        <h6 class="text-muted">Test Volume Trends (Coming Soon)</h6>
                        <p class="small text-muted mb-0">Visual analytics for lab tests will be integrated here.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-primary-subtle p-4 rounded-4">
                        <h6 class="fw-bold text-primary mb-3">Quick Summary</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Completion Rate</span>
                                <span class="fw-bold text-dark">{{ $stats['total_tests'] > 0 ? round(($stats['completed'] / $stats['total_tests']) * 100, 1) : 0 }}%</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Avg. Turnaround</span>
                                <span class="fw-bold text-dark">1.2 Days</span>
                            </li>
                            <li class="d-flex justify-content-between small">
                                <span class="text-muted">Revenue Generated</span>
                                <span class="fw-bold text-success">0.00 TZS</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 0.5px; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>
@endsection
