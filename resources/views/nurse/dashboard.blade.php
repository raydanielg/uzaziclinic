@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="nurse-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background: linear-gradient(135deg, #064e3b 0%, #059669 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-user-nurse"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Nurse</p>
                            <h4 class="mb-0 fw-bold">Welcome, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Today's Patients: <strong>{{ $stats['today_patients'] }}</strong> &bull; Queue: <strong>{{ $stats['waiting_queue'] }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-user-check"></i></div>
                        <div>
                            <div class="stat-label">Today's Patients</div>
                            <div class="stat-value" data-count="{{ $stats['today_patients'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div>
                            <div class="stat-label">Waiting</div>
                            <div class="stat-value" data-count="{{ $stats['waiting_queue'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-bed-pulse"></i></div>
                        <div>
                            <div class="stat-label">Occupied Beds</div>
                            <div class="stat-value" data-count="{{ $stats['occupied_beds'] }}">0</div>
                            <div class="stat-trend text-muted">of {{ $stats['total_beds'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-flask"></i></div>
                        <div>
                            <div class="stat-label">Pending Labs</div>
                            <div class="stat-value" data-count="{{ $stats['pending_labs'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent Patients Table --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-users me-2 text-green"></i>Recently Registered Patients</h6>
                        <a href="{{ route('nurse.patients') }}" class="btn btn-sm btn-light fw-semibold px-3">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Patient</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Action</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recent_patients as $patient)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-green-soft text-green">{{ strtoupper(substr($patient->name,0,1)) }}</div>
                                            <div>
                                                <div class="fw-semibold small">{{ $patient->name }}</div>
                                                <div class="text-muted" style="font-size:.7rem">#PT-{{ $patient->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-semibold">{{ $patient->phone ?? 'N/A' }}</td>
                                    <td class="small text-muted">{{ $patient->created_at->format('d M Y') }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('nurse.vitals') }}" class="btn btn-sm btn-light fw-semibold px-3 rounded-2">Vitals</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-user-slash fs-2 opacity-25 d-block mb-2"></i>No patients
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Ward Status --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header" style="background:linear-gradient(135deg,#064e3b,#059669);border:none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 opacity-75 small fw-semibold text-white text-uppercase">Ward Status</p>
                                <h5 class="mb-0 fw-bold text-white">
                                    @php $pct = $stats['total_beds'] > 0 ? round($stats['occupied_beds']/$stats['total_beds']*100) : 0; @endphp
                                    {{ $pct }}% Occupied
                                </h5>
                            </div>
                            <i class="fa-solid fa-hospital-user text-white opacity-25 fs-2"></i>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @foreach([
                            ['General Ward','#10b981',90,'18/20'],
                            ['Maternity Ward','#3b82f6',80,'12/15'],
                            ['ICU / Emergency','#f59e0b',40,'4/10'],
                        ] as [$ward,$color,$pct2,$beds])
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-semibold">{{ $ward }}</span>
                                <span class="small text-muted">{{ $beds }}</span>
                            </div>
                            <div class="progress-modern">
                                <div class="progress-fill" style="width:{{ $pct2 }}%;background:{{ $color }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Tools --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Quick Tools</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-user-plus','bg-blue-soft text-blue',route('nurse.checkin'),'Check-in Patient'],
                            ['fa-list-ol','bg-amber-soft text-amber',route('nurse.queue'),'View Queue'],
                            ['fa-flask-vial','bg-cyan-soft text-cyan',route('nurse.lab-collection'),'Lab Samples'],
                            ['fa-bed-pulse','bg-green-soft text-green',route('nurse.bed-allocation'),'Bed Allocation'],
                            ['fa-pills','bg-violet-soft text-violet',route('nurse.medication'),'Medication'],
                            ['fa-clipboard-list','bg-rose-soft text-rose',route('nurse.vitals'),'Vitals'],
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
@endsection
