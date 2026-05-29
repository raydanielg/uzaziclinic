@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="doctor-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background: linear-gradient(135deg, #0f4c75 0%, #1b6ca8 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Doctor</p>
                            <h4 class="mb-0 fw-bold">Welcome, Dr. {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Today's Appointments: <strong>{{ $stats['today_appointments'] }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-calendar-check"></i></div>
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
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-hospital-user"></i></div>
                        <div>
                            <div class="stat-label">My Patients</div>
                            <div class="stat-value" data-count="{{ $stats['total_patients'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div>
                            <div class="stat-label">Pending Reviews</div>
                            <div class="stat-value" data-count="{{ $stats['pending_reviews'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-violet h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-violet"><i class="fa-solid fa-chart-line"></i></div>
                        <div>
                            <div class="stat-label">Performance</div>
                            <div class="stat-value" data-count="94" data-suffix="%">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Appointments Table --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-clock me-2 text-blue"></i>Recent Appointments</h6>
                        <a href="{{ route('doctor.schedule') }}" class="btn btn-sm btn-light fw-semibold px-3">My Schedule</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Patient</th>
                                <th>Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recent_appointments as $appointment)
                                @php
                                    $pName = $appointment->user->name ?? 'N/A';
                                    $sc = match($appointment->status ?? 'pending') {
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
                                                <div class="text-muted" style="font-size:.7rem">#{{ $appointment->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold small">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</div>
                                        <div class="text-muted" style="font-size:.7rem">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge {{ $sc[0] }}"><i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($appointment->status ?? 'pending') }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                                <li><a class="dropdown-item small" href="{{ route('doctor.prescriptions.add') }}"><i class="fa-solid fa-file-prescription me-2 text-cyan"></i>Prescribe</a></li>
                                                <li><a class="dropdown-item small" href="{{ route('doctor.lab.requests') }}"><i class="fa-solid fa-flask me-2 text-amber"></i>Lab Test</a></li>
                                                <li><a class="dropdown-item small" href="{{ route('doctor.medical.records') }}"><i class="fa-solid fa-notes-medical me-2 text-violet"></i>Records</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>No appointments currently
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Quick Actions --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Quick Actions</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-file-prescription','bg-cyan-soft text-cyan',route('doctor.prescriptions.add'),'Write Prescription'],
                            ['fa-microscope','bg-amber-soft text-amber',route('doctor.lab.requests'),'Request Lab Test'],
                            ['fa-notes-medical','bg-blue-soft text-blue',route('doctor.medical.records'),'Medical Records'],
                            ['fa-calendar-days','bg-green-soft text-green',route('doctor.schedule'),'My Schedule'],
                            ['fa-comments','bg-violet-soft text-violet',route('doctor.chat'),'Chat'],
                            ['fa-chart-bar','bg-rose-soft text-rose',route('doctor.reports'),'Reports'],
                        ] as [$icon,$cls,$href,$label])
                        <a href="{{ $href }}" class="quick-action-item">
                            <div class="qa-icon {{ $cls }}"><i class="fa-solid {{ $icon }}"></i></div>
                            <span>{{ $label }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Performance Chart --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-bar me-2 text-blue"></i>Weekly Summary</h6></div>
                    <div class="card-body"><canvas id="doctorWeekChart" height="180"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('doctorWeekChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [
                    { label: 'Appointments', data: [3,5,4,8,6,2,1], backgroundColor: 'rgba(59,130,246,0.8)', borderRadius: 6 },
                    { label: 'Patients', data: [2,4,3,6,5,1,0], backgroundColor: 'rgba(16,185,129,0.8)', borderRadius: 6 }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10 } } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
        });
    }
});
</script>
@endpush
@endsection
