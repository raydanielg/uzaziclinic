@extends('layouts.admin')

@section('page_title', 'Analytics Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
            <div class="avatar-lg bg-primary-subtle text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
            </div>
            <h6 class="fw-bold">Financial Reports</h6>
            <p class="text-muted small">Revenue, expenses, and profit analytics.</p>
            <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">Generate Report</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
            <div class="avatar-lg bg-success-subtle text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-user-injured fa-2x"></i>
            </div>
            <h6 class="fw-bold">Patient Analytics</h6>
            <p class="text-muted small">Registration trends and demographics.</p>
            <a href="{{ route('admin.reports.patients') }}" class="btn btn-outline-success btn-sm rounded-pill w-100">Generate Report</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
            <div class="avatar-lg bg-orange-subtle text-orange rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #ffedd5; color: #c2410c;">
                <i class="fa-solid fa-box-open fa-2x"></i>
            </div>
            <h6 class="fw-bold">Inventory Reports</h6>
            <p class="text-muted small">Stock levels and medicine expiry reports.</p>
            <a href="{{ route('admin.reports.stock') }}" class="btn btn-outline-warning btn-sm rounded-pill w-100" style="color: #c2410c; border-color: #c2410c;">Generate Report</a>
        </div>
    </div>
</div>
@endsection
