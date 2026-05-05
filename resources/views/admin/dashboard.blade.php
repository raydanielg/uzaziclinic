@extends('layouts.admin')

@section('content')
<div class="row g-4 mb-4">
    <!-- Row 1: Key Financials & Patients -->
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
                <div class="stat-title">Total Revenue Today</div>
                <div class="stat-value">TSh 1,250,000</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
        <div class="stat-card">
            <div class="stat-icon bg-indigo-light">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="stat-title">Total Patients Registered</div>
                <div class="stat-value">1,482</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <div class="stat-title">Total Appointments Today</div>
                <div class="stat-value">42</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
        <div class="stat-card">
            <div class="stat-icon bg-orange-light">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="stat-title">Pending Appointments</div>
                <div class="stat-value">12</div>
            </div>
        </div>
    </div>

    <!-- Row 2: Operations & Doctors -->
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
        <div class="stat-card">
            <div class="stat-icon bg-danger-light" style="background-color: #fee2e2; color: #ef4444;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="stat-title">Low Stock Alert</div>
                <div class="stat-value text-danger">8 Items</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
        <div class="stat-card">
            <div class="stat-icon bg-purple-light">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <div class="stat-title">Products Sold Today</div>
                <div class="stat-value">24</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
        <div class="stat-card">
            <div class="stat-icon bg-primary-light" style="background-color: #e0f2fe; color: #0ea5e9;">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div>
                <div class="stat-title">Active Doctors</div>
                <div class="stat-value">15</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <i class="fa-solid fa-house-user"></i>
            </div>
            <div>
                <div class="stat-title">Today's Completed Visits</div>
                <div class="stat-value">28</div>
            </div>
        </div>
    </div>

    <!-- Row 3: Finance & Progress -->
    <div class="col-xl-3 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.9s;">
        <div class="stat-card">
            <div class="stat-icon bg-warning-light" style="background-color: #fef3c7; color: #d97706;">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <div class="stat-title">Pending Invoices</div>
                <div class="stat-value">TSh 450k</div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 1.0s;">
        <div class="stat-card d-block">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="stat-title mb-0">Monthly Revenue Target Progress</div>
                <div class="stat-value" style="font-size: 0.9rem;">75% (TSh 15M / 20M)</div>
            </div>
            <div class="progress" style="height: 10px; border-radius: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 75%; border-radius: 10px;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Column -->
    <div class="col-lg-8 animate__animated animate__fadeInLeft" style="animation-delay: 1.1s;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-4">Patient & Revenue Trend (Last 14 Days)</h6>
            <div style="height: 300px;">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Distribution Column -->
    <div class="col-lg-4 animate__animated animate__fadeInRight" style="animation-delay: 1.1s;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-4">Department Distribution</h6>
            <div style="height: 250px;">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-6 animate__animated animate__fadeInUp" style="animation-delay: 1.2s;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">Recent Patient Payments</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 0.85rem;">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>DATE</th>
                            <th>PATIENT</th>
                            <th>SERVICE</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: 1.3s;">
                            <td>May 05, 2026</td>
                            <td class="fw-600">Sarah Johnson</td>
                            <td>Maternity Checkup</td>
                            <td>TSh 45,000</td>
                            <td><span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Paid</span></td>
                        </tr>
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: 1.4s;">
                            <td>May 05, 2026</td>
                            <td class="fw-600">David Mwangi</td>
                            <td>Lab Test (Full Blood)</td>
                            <td>TSh 25,000</td>
                            <td><span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Paid</span></td>
                        </tr>
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: 1.5s;">
                            <td>May 04, 2026</td>
                            <td class="fw-600">Aisha Bakari</td>
                            <td>Pharmacy (Medicines)</td>
                            <td>TSh 120,000</td>
                            <td><span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill">Pending</span></td>
                        </tr>
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: 1.6s;">
                            <td>May 04, 2026</td>
                            <td class="fw-600">John Peter</td>
                            <td>Consultation</td>
                            <td>TSh 30,000</td>
                            <td><span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 animate__animated animate__fadeInUp" style="animation-delay: 1.2s;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">CRM Inbox (Latest Queries)</h6>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 py-3 border-bottom border-light animate__animated animate__fadeIn" style="animation-delay: 1.3s;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 small fw-bold">Appointment Reschedule</h6>
                        <span class="text-muted small" style="font-size: 0.7rem;">2h ago</span>
                    </div>
                    <p class="mb-0 text-muted small">I would like to move my maternity checkup to Saturday morning...</p>
                </div>
                <div class="list-group-item px-0 py-3 border-bottom border-light animate__animated animate__fadeIn" style="animation-delay: 1.4s;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 small fw-bold">Lab Results Inquiry</h6>
                        <span class="text-muted small" style="font-size: 0.7rem;">5h ago</span>
                    </div>
                    <p class="mb-0 text-muted small">Are the blood test results for patient Aisha Bakari ready yet?</p>
                </div>
                <div class="list-group-item px-0 py-3 border-0 animate__animated animate__fadeIn" style="animation-delay: 1.5s;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 small fw-bold">Emergency Bed Request</h6>
                        <span class="text-muted small" style="font-size: 0.7rem;">1d ago</span>
                    </div>
                    <p class="mb-0 text-muted small">Inquiry about ward availability for a patient coming from out of town...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Activity Chart (Mothers, Payments, etc.)
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    // Create gradients
    const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, 'rgba(54, 92, 245, 0.4)');
    blueGradient.addColorStop(1, 'rgba(54, 92, 245, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2026-04-22', '2026-04-23', '2026-04-24', '2026-04-25', '2026-04-26', '2026-04-27', '2026-04-28', '2026-04-29', '2026-04-30', '2026-05-01', '2026-05-02', '2026-05-03', '2026-05-04', '2026-05-05'],
            datasets: [
                {
                    label: 'Mothers',
                    data: [6, 11, 4, 7, 6, 5, 0, 1, 0, 0, 1, 0, 3, 0],
                    borderColor: '#365cf5',
                    backgroundColor: blueGradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#365cf5'
                },
                {
                    label: 'Payments',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#10b981',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981'
                },
                {
                    label: 'Investor Txns',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#f59e0b',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                },
                {
                    label: 'CRM Inbox',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    borderColor: '#8b5cf6',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 40,
                        boxHeight: 15,
                        padding: 20,
                        usePointStyle: false,
                        font: { size: 12 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 12,
                    ticks: { stepSize: 2 },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: true, color: '#f1f5f9' }
                }
            }
        }
    });

    // Department Distribution Chart (Donut)
    const dtx = document.getElementById('distributionChart').getContext('2d');
    new Chart(dtx, {
        type: 'doughnut',
        data: {
            labels: ['Maternity', 'Pediatrics', 'General', 'Lab', 'Pharmacy'],
            datasets: [{
                data: [35, 20, 25, 10, 10],
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 8, usePointStyle: true, font: { size: 10 } } }
            }
        }
    });
</script>
@endpush
