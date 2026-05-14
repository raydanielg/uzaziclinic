@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="admin-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero Welcome --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold">ADMIN PANEL</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Muhtasari kamili wa mfumo</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-primary-soft text-primary me-3">
                                <i class="fa-solid fa-user-injured fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Total Patients</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-success-soft text-success me-3">
                                <i class="fa-solid fa-user-doctor fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Total Doctors</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_doctors'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-warning-soft text-warning me-3">
                                <i class="fa-solid fa-calendar-check fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Today Appointments</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-info-soft text-info me-3">
                                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Pending Orders</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ $stats['pending_orders'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Appointments -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold">Recent Appointments</h5>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light text-primary fw-bold">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Patient</th>
                                        <th>Doctor</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAppointments as $appt)
                                        @php
                                            $patientName = $appt->patient?->display_name ?? 'Patient';
                                            $doctorName = $appt->doctor?->display_name ?? 'Doctor';
                                            $status = $appt->status ?? 'pending';
                                            $statusClass = match($status) {
                                                'confirmed' => 'primary',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                default => 'warning',
                                            };
                                        @endphp
                                        <tr>
                                            <td class="ps-4 fw-semibold">{{ $patientName }}</td>
                                            <td>{{ $doctorName }}</td>
                                            <td class="text-muted">{{ optional($appt->appointment_date)->format('d M Y, H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} text-uppercase">{{ $status }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-secondary rounded-2">Open</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="5" class="text-muted py-4">Hakuna miadi kwa sasa.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Appointments Trend</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="appointmentsTrendChart" height="160"></canvas>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Orders Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersStatusChart" height="160"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-success-soft text-success me-3">
                                <i class="fa-solid fa-file-invoice-dollar fa-xl"></i>
                            </div>
                            <h6 class="card-subtitle text-muted fw-bold">Total Revenue (Paid)</h6>
                        </div>
                        <div class="d-flex align-items-end justify-content-between">
                            <h2 class="mb-0 fw-bold">{{ number_format($stats['total_revenue'] ?? 0) }}</h2>
                        </div>
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

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-card { border-radius: 12px; }

    .quick-action-btn {
        display: block;
        padding: 1.25rem;
        background-color: #f8fafc;
        border-radius: 12px;
        text-decoration: none;
        color: #475569;
        text-align: center;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .quick-action-btn:hover {
        background-color: #fff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        color: #1e293b;
    }
    .quick-action-btn span {
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const charts = @json($charts ?? []);

            const aCtx = document.getElementById('appointmentsTrendChart');
            if (aCtx && charts.appointments) {
                new Chart(aCtx, {
                    type: 'line',
                    data: {
                        labels: charts.appointments.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: charts.appointments.data,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.12)',
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true },
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const oCtx = document.getElementById('ordersStatusChart');
            if (oCtx && charts.orders) {
                new Chart(oCtx, {
                    type: 'doughnut',
                    data: {
                        labels: charts.orders.labels,
                        datasets: [{
                            data: charts.orders.data,
                            backgroundColor: [
                                '#f59e0b',
                                '#0d6efd',
                                '#16a34a',
                                '#dc2626'
                            ],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        },
                        cutout: '65%'
                    }
                });
            }
        });
    </script>
@endpush
@endsection
