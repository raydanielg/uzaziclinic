@extends('layouts.admin')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-indigo-light">
                <i class="fa-solid fa-person"></i>
            </div>
            <div>
                <div class="stat-title">Mothers Total</div>
                <div class="stat-value">336</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div>
                <div class="stat-title">New Mothers Today</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-orange-light">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="stat-title">Investors</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-purple-light">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <div class="stat-title">Active Investors</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <div class="stat-title">Investor Balances</div>
                <div class="stat-value">TSh 0</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-orange-light">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>
            <div>
                <div class="stat-title">Sales (MTD)</div>
                <div class="stat-value">TSh 0</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Column -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-4">Activity Trend (Last 14 Days)</h6>
            <div style="height: 300px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Distribution Column -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <h6 class="fw-bold mb-4">Distribution</h6>
            <div class="d-flex justify-content-center align-items-center" style="height: 250px;">
                <div style="width: 200px; height: 200px; border-radius: 50%; border: 20px solid #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.8rem;">
                    No data
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-4">Recent Payments</h6>
            <div class="text-center py-5 text-muted small">No payments</div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-4">Recent Investor Transactions</h6>
            <div class="text-center py-5 text-muted small">No transactions</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2026-04-22', '2026-04-23', '2026-04-24', '2026-04-25', '2026-04-26', '2026-04-27', '2026-04-28', '2026-04-29', '2026-04-30', '2026-05-01', '2026-05-02', '2026-05-03', '2026-05-04', '2026-05-05'],
            datasets: [{
                label: 'Mothers',
                data: [6, 11, 4, 7, 6, 5, 0, 1, 0, 1, 0, 3, 0],
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
