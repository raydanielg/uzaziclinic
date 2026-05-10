@extends('layouts.app')

@section('content')
<div class="doctor-reports py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Performance Reports</h4>
                <p class="text-muted small">Analyze your clinical activities and patient satisfaction metrics</p>
            </div>
            <button class="btn btn-light rounded-1 px-4 border-0 text-primary fw-bold shadow-sm">
                <i class="fa-solid fa-download me-2"></i> Export PDF
            </button>
        </div>

        <!-- Summary Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="text-muted small fw-bold text-uppercase ls-1 mb-2">Patients Seen</div>
                    <div class="h3 fw-bold mb-0">1,284</div>
                    <div class="text-success small mt-2"><i class="fa-solid fa-arrow-up me-1"></i> 12% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="text-muted small fw-bold text-uppercase ls-1 mb-2">Avg. Consultation</div>
                    <div class="h3 fw-bold mb-0">18 min</div>
                    <div class="text-muted small mt-2">Optimal efficiency</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="text-muted small fw-bold text-uppercase ls-1 mb-2">Satisfaction Rate</div>
                    <div class="h3 fw-bold mb-0">98.2%</div>
                    <div class="text-warning small mt-2">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white text-white" style="background: linear-gradient(45deg, #166534, #15803d);">
                    <div class="opacity-75 small fw-bold text-uppercase ls-1 mb-2">Revenue Generated</div>
                    <div class="h3 fw-bold mb-0">TZS 4.2M</div>
                    <div class="opacity-75 small mt-2">Service billings</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Productivity Chart Placeholder -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-bold mb-4">Patient Volume Trends</h6>
                    <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 300px; border: 2px dashed #e2e8f0;">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-line fs-1 text-muted opacity-25 mb-3"></i>
                            <p class="text-muted small">Analytics data visualization will appear here.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Diagnoses -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-bold mb-4">Top Diagnoses</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-3 border-0 d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-dark">Prenatal Care</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill">42%</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-light d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-dark">Routine Checkup</span>
                            <span class="badge bg-success-subtle text-success rounded-pill">28%</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-light d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-dark">Postnatal Recovery</span>
                            <span class="badge bg-info-subtle text-info rounded-pill">15%</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-light d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-dark">Immunization</span>
                            <span class="badge bg-warning-subtle text-warning rounded-pill">10%</span>
                        </div>
                        <div class="list-group-item px-0 py-3 border-light d-flex justify-content-between align-items-center">
                            <span class="small fw-bold text-dark">Other</span>
                            <span class="badge bg-light text-muted border rounded-pill">5%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
