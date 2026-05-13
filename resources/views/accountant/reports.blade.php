@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Financial Reports</h1>
                <p class="text-muted small mb-0">Revenue, expenses, profit & loss analysis.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary rounded-2 me-2" onclick="window.print()">
                    <i class="fa-solid fa-print me-2"></i>Print
                </button>
                <button class="btn btn-primary rounded-2">
                    <i class="fa-solid fa-file-export me-2"></i>Export PDF
                </button>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <form class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label small fw-bold mb-1">From</label>
                        <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-01') }}">
                    </div>
                    <div class="col-auto">
                        <label class="form-label small fw-bold mb-1">To</label>
                        <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-auto">
                        <label class="form-label small fw-bold mb-1">Report Type</label>
                        <select class="form-select form-select-sm">
                            <option>All</option>
                            <option>Revenue</option>
                            <option>Expenses</option>
                            <option>Profit & Loss</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm rounded-2">
                            <i class="fa-solid fa-filter me-1"></i>Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Total Revenue</p>
                    <h3 class="fw-bold text-success mb-0">TZS 0</h3>
                    <small class="text-muted">This month</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Total Expenses</p>
                    <h3 class="fw-bold text-danger mb-0">TZS 0</h3>
                    <small class="text-muted">This month</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Net Profit</p>
                    <h3 class="fw-bold text-primary mb-0">TZS 0</h3>
                    <small class="text-muted">This month</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Pending Collection</p>
                    <h3 class="fw-bold text-warning mb-0">TZS 0</h3>
                    <small class="text-muted">Unpaid invoices</small>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Revenue Trend (12 Months)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-pie me-2 text-success"></i>Revenue Breakdown</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="breakdownChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue (TZS)',
                data: Array(12).fill(0),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.08)',
                fill: true,
                tension: 0.35,
                pointRadius: 3,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('breakdownChart'), {
        type: 'doughnut',
        data: {
            labels: ['Consultation','Pharmacy','Laboratory','Admission'],
            datasets: [{ data: [0,0,0,0], backgroundColor: ['#0d6efd','#198754','#ffc107','#dc3545'], borderWidth: 0 }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
    });
});
</script>
@endpush
@endsection
