@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="receptionist-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#1e3a5f 0%,#0e7490 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-hospital"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-person-desk"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Receptionist</p>
                            <h4 class="mb-0 fw-bold">Welcome, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Today's Appointments: <strong>{{ $stats['today_appointments'] }}</strong> &bull; Total Patients: <strong>{{ $stats['total_patients'] }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-calendar-day"></i></div>
                        <div>
                            <div class="stat-label">Today's Appointments</div>
                            <div class="stat-value" data-count="{{ $stats['today_appointments'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-user-plus"></i></div>
                        <div>
                            <div class="stat-label">New Patients</div>
                            <div class="stat-value" data-count="{{ $stats['pending_registrations'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-user-doctor"></i></div>
                        <div>
                            <div class="stat-label">Active Doctors</div>
                            <div class="stat-value" data-count="{{ $stats['active_doctors'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-users"></i></div>
                        <div>
                            <div class="stat-label">Total Patients</div>
                            <div class="stat-value" data-count="{{ $stats['total_patients'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent Appointments --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-clock me-2 text-blue"></i>Recent Appointments</h6>
                        <a href="{{ route('receptionist.appointments') }}" class="btn btn-sm btn-light fw-semibold px-3">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Patient</th>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th class="text-end pe-3">Status</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recent_appointments as $app)
                                @php
                                    $pName = $app->user->name ?? 'N/A';
                                    $sc = match($app->status ?? 'pending') {
                                        'confirmed' => ['bg-blue-soft text-blue','fa-circle-check'],
                                        'completed' => ['bg-green-soft text-green','fa-check-double'],
                                        'cancelled' => ['bg-rose-soft text-rose','fa-circle-xmark'],
                                        default     => ['bg-amber-soft text-amber','fa-clock'],
                                    };
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-blue-soft text-blue">{{ strtoupper(substr($pName,0,1)) }}</div>
                                            <div>
                                                <div class="fw-semibold small">{{ $pName }}</div>
                                                <div class="text-muted" style="font-size:.7rem">#PT-{{ $app->user_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-semibold">Dkt. {{ $app->doctor->name ?? 'N/A' }}</td>
                                    <td class="small text-muted">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i, d M') }}</td>
                                    <td class="text-end pe-3">
                                        <span class="status-badge {{ $sc[0] }}"><i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($app->status ?? 'pending') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>No appointments
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Weekly Chart --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-bar me-2 text-cyan"></i>This Week's Appointments</h6></div>
                    <div class="card-body"><canvas id="receptionistChart" height="185"></canvas></div>
                </div>
                {{-- Quick Actions --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Quick Actions</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-calendar-check','bg-blue-soft text-blue',route('receptionist.appointments'),'View Appointments'],
                            ['fa-users','bg-green-soft text-green',route('receptionist.patients'),'Patient List'],
                            ['fa-user-doctor','bg-cyan-soft text-cyan',route('receptionist.doctors'),'Doctor Directory'],
                            ['fa-user','bg-violet-soft text-violet',route('receptionist.profile'),'My Profile'],
                        ] as [$icon,$cls,$href,$label])
                        <a href="{{ $href }}" class="quick-action-item">
                            <div class="qa-icon {{ $cls }}"><i class="fa-solid {{ $icon }}"></i></div>
                            <span>{{ $label }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('receptionistChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Appointments',
                    data: [8,12,9,15,11,5,3],
                    backgroundColor: 'rgba(14,116,144,0.8)',
                    borderRadius: 6, borderSkipped: false
                }]
            },
            options: { responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } } } }
        });
    }
});
</script>
@endpush
@endsection
