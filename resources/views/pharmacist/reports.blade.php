@extends('layouts.app')

@section('content')
<div class="pharmacist-reports py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Pharmacy Reports</h4>
                <p class="text-muted small">Generate and view detailed pharmacy insights.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                    <div class="bg-primary-soft text-primary rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-chart-line fa-xl"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Daily Sales Report</h6>
                    <p class="small text-muted mb-4">Track revenue and prescription counts for today.</p>
                    <button class="btn btn-outline-primary w-100 rounded-1 fw-bold">Download PDF</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                    <div class="bg-danger-soft text-danger rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-calendar-times fa-xl"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Expiry Analysis</h6>
                    <p class="small text-muted mb-4">List of medicines expiring in the next 3 months.</p>
                    <button class="btn btn-outline-danger w-100 rounded-1 fw-bold">Generate List</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                    <div class="bg-info-soft text-info rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-boxes-stacked fa-xl"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Stock Level Report</h6>
                    <p class="small text-muted mb-4">Detailed inventory balance and stock values.</p>
                    <button class="btn btn-outline-info w-100 rounded-1 fw-bold">View Full Report</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
