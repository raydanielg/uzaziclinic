@extends('layouts.admin')
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
                            <h4 class="mb-0 fw-bold">Welcome, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Complete system overview</p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-user-injured"></i></div>
                        <div class="flex-grow-1">
                            <div class="stat-label">Total Patients</div>
                            <div class="stat-value" data-count="{{ $stats['total_patients'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-user-doctor"></i></div>
                        <div class="flex-grow-1">
                            <div class="stat-label">Total Doctors</div>
                            <div class="stat-value" data-count="{{ $stats['total_doctors'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="flex-grow-1">
                            <div class="stat-label">Today's Appointments</div>
                            <div class="stat-value" data-count="{{ $stats['today_appointments'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-rose h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-rose"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div class="flex-grow-1">
                            <div class="stat-label">Total Revenue</div>
                            <div class="stat-value" data-count="{{ $stats['total_revenue'] ?? 0 }}" data-prefix="TZS ">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-6">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-money-bill-wave"></i></div>
                        <div class="flex-grow-1">
                            <div class="stat-label">Pending Payments</div>
                            <div class="stat-value" data-count="{{ $stats['pending_payments'] ?? 0 }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Row --}}
        <div class="row g-4 mb-4">
            {{-- Recent Appointments Table --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-clock me-2 text-blue"></i>Recent Appointments</h6>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light fw-semibold px-3">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Patient</th>
                                <th>Doctor</th>
                                <th>Date &amp; Time</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Action</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recentAppointments as $appt)
                                @php
                                    $patientName = $appt->patient->name ?? 'Patient';
                                    $doctorName  = $appt->doctor->display_name ?? 'Doctor';
                                    $status      = $appt->status ?? 'pending';
                                    $sc = match($status) {
                                        'confirmed' => ['bg-blue-soft text-blue', 'fa-circle-check'],
                                        'completed' => ['bg-green-soft text-green', 'fa-check-double'],
                                        'cancelled' => ['bg-rose-soft text-rose', 'fa-circle-xmark'],
                                        default     => ['bg-amber-soft text-amber', 'fa-clock'],
                                    };
                                    $initials = strtoupper(substr($patientName,0,1));
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-blue-soft text-blue">{{ $initials }}</div>
                                            <div>
                                                <div class="fw-semibold text-dark small">{{ $patientName }}</div>
                                                <div class="text-muted" style="font-size:0.7rem">#PT-{{ $appt->patient_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-semibold">Dr. {{ $doctorName }}</td>
                                    <td class="small text-muted">{{ optional($appt->appointment_date)->format('d M Y, H:i') }}</td>
                                    <td><span class="status-badge {{ $sc[0] }}"><i class="fa-solid {{ $sc[1] }} me-1"></i>{{ $status }}</span></td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light rounded-2 px-3 fw-semibold">Open</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>No appointments currently
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-4 anim-6">
                {{-- Appointments Trend Chart --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-line me-2 text-blue"></i>Appointments Trend</h6>
                    </div>
                    <div class="card-body"><canvas id="appointmentsTrendChart" height="180"></canvas></div>
                </div>
                {{-- Orders Donut --}}
                <div class="dash-chart-card">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-donut me-2 text-violet"></i>Orders Status</h6>
                    </div>
                    <div class="card-body"><canvas id="ordersStatusChart" height="180"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Quick Actions Grid --}}
        <div class="row g-3 anim-6">
            <div class="col-12">
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Quick Actions</h6></div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach([
                                ['fa-users','bg-blue-soft text-blue', route('admin.users.index'), 'Users'],
                                ['fa-user-injured','bg-green-soft text-green', route('admin.patients.index'), 'Patients'],
                                ['fa-user-doctor','bg-cyan-soft text-cyan', route('admin.doctors.index'), 'Doctors'],
                                ['fa-calendar-check','bg-amber-soft text-amber', route('admin.appointments.index'), 'Appointments'],
                                ['fa-money-bill-wave','bg-rose-soft text-rose', route('admin.payments'), 'Payments'],
                                ['fa-pills','bg-violet-soft text-violet', route('admin.pharmacy.stock'), 'Pharmacy'],
                                ['fa-flask-vial','bg-cyan-soft text-cyan', route('admin.lab.catalog'), 'Lab'],
                                ['fa-chart-pie','bg-blue-soft text-blue', route('admin.reports.patients'), 'Reports'],
                            ] as [$icon, $cls, $href, $label])
                            <div class="col-6 col-md-3 col-xl-1-5">
                                <a href="{{ $href }}" class="quick-action-item flex-column text-center py-3 justify-content-center">
                                    <div class="qa-icon {{ $cls }} mb-2" style="width:42px;height:42px;margin:auto;border-radius:12px">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>
                                    <span class="small fw-bold">{{ $label }}</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
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
    const charts = @json($charts ?? []);
    const chartDefaults = { responsive: true, maintainAspectRatio: true };

    // Appointments Trend
    const aCtx = document.getElementById('appointmentsTrendChart');
    if (aCtx) {
        const labels = charts.appointments?.labels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        const data   = charts.appointments?.data   ?? [4,7,5,9,6,8,5];
        new Chart(aCtx, {
            type: 'line',
            data: {
                labels,
                datasets: [{ label: 'Appointments', data, borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)', fill: true,
                    tension: 0.4, pointRadius: 4, pointBackgroundColor: '#3b82f6',
                    pointHoverRadius: 6 }]
            },
            options: { ...chartDefaults, plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
                          x: { grid: { display: false } } } }
        });
    }

    // Orders Donut
    const oCtx = document.getElementById('ordersStatusChart');
    if (oCtx) {
        const labels = charts.orders?.labels ?? ['Pending','Processing','Completed','Cancelled'];
        const data   = charts.orders?.data   ?? [12, 5, 48, 3];
        new Chart(oCtx, {
            type: 'doughnut',
            data: { labels, datasets: [{ data,
                backgroundColor: ['#f59e0b','#3b82f6','#10b981','#f43f5e'],
                borderWidth: 0, hoverOffset: 6 }] },
            options: { ...chartDefaults, cutout: '68%',
                plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } } } }
        });
    }
});
</script>
@endpush
@endsection
