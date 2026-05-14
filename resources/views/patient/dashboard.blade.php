@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="patient-dashboard py-4">
    <div class="container-fluid">

        <!-- Welcome Header -->
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 60%,#06b6d4 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-hospital-user"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-user-injured"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Portal ya Mgonjwa</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}!</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">Nambari ya Mgonjwa: <strong>#PT-{{ str_pad(Auth::id(),4,'0',STR_PAD_LEFT) }}</strong> &bull; {{ now()->format('l, d F Y') }}</p>
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
                            <div class="stat-label">Miadi Yangu</div>
                            <div class="stat-value" data-count="{{ $stats['total_appointments'] ?? 0 }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-file-prescription"></i></div>
                        <div>
                            <div class="stat-label">Maagizo Yangu</div>
                            <div class="stat-value" data-count="{{ $stats['total_prescriptions'] ?? 0 }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-flask-vial"></i></div>
                        <div>
                            <div class="stat-label">Matokeo ya Lab</div>
                            <div class="stat-value" data-count="{{ $stats['lab_results'] ?? 0 }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <div>
                            <div class="stat-label">Bili Zinazosubiri</div>
                            <div class="stat-value" data-count="{{ $stats['pending_bills'] ?? 0 }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8 anim-5">

                {{-- Upcoming Appointments --}}
                <div class="dash-table-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-days me-2 text-blue"></i>Miadi Inayokuja</h6>
                        <a href="{{ route('patient.appointments') }}" class="btn btn-sm btn-primary rounded-2 px-3">
                            <i class="fa-solid fa-plus me-1"></i>Weka Miadi
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Daktari</th>
                                <th>Tarehe &amp; Muda</th>
                                <th>Aina</th>
                                <th class="text-end pe-3">Hali</th>
                            </tr></thead>
                            <tbody>
                                @forelse($upcoming_appointments ?? [] as $appt)
                                @php
                                    $sc = match($appt->status ?? 'pending') {
                                        'confirmed' => ['bg-blue-soft text-blue','fa-circle-check'],
                                        'completed' => ['bg-green-soft text-green','fa-check-double'],
                                        'cancelled' => ['bg-rose-soft text-rose','fa-circle-xmark'],
                                        default     => ['bg-amber-soft text-amber','fa-clock'],
                                    };
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-blue-soft text-blue">
                                                {{ strtoupper(substr($appt->doctor->name ?? 'D',0,1)) }}
                                            </div>
                                            <span class="fw-semibold small">Dkt. {{ $appt->doctor->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="small text-muted">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y, H:i') }}</td>
                                    <td class="small">{{ $appt->type ?? 'Consultation' }}</td>
                                    <td class="text-end pe-3">
                                        <span class="status-badge {{ $sc[0] }}"><i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($appt->status ?? 'pending') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>
                                    Hakuna miadi. <a href="{{ route('patient.appointments') }}" class="text-blue fw-semibold">Weka sasa</a>.
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Active Prescriptions --}}
                <div class="dash-table-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-file-prescription me-2 text-green"></i>Maagizo ya Dawa</h6>
                        <a href="{{ route('patient.prescriptions') }}" class="btn btn-sm btn-light fw-semibold px-3">Yote</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Dawa</th>
                                <th>Kipimo</th>
                                <th>Mara ngapi</th>
                                <th class="text-end pe-3">Muda</th>
                            </tr></thead>
                            <tbody>
                                @forelse($active_prescriptions ?? [] as $rx)
                                <tr>
                                    <td class="ps-3 fw-semibold small">{{ $rx->medicine_name ?? $rx->medicine->name ?? 'N/A' }}</td>
                                    <td class="small text-muted">{{ $rx->dosage ?? 'N/A' }}</td>
                                    <td class="small">{{ $rx->frequency ?? 'N/A' }}</td>
                                    <td class="text-end pe-3 small text-muted">{{ $rx->duration ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-pills fs-2 opacity-25 d-block mb-2"></i>Hakuna maagizo ya dawa
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4 anim-6">
                {{-- Profile Card --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-blue-soft text-blue rounded-circle"
                            style="width:72px;height:72px;font-size:1.8rem;">
                            <i class="fa-solid fa-user-injured"></i>
                        </div>
                        <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                        <p class="text-muted small mb-2">{{ Auth::user()->email }}</p>
                        <span class="status-badge bg-blue-soft text-blue">Mgonjwa</span>
                        <div class="d-grid mt-3">
                            <a href="{{ route('patient.profile') }}" class="btn btn-sm btn-light fw-semibold rounded-2">
                                <i class="fa-solid fa-pen me-1"></i>Hariri Wasifu
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Vitendo vya Haraka</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-calendar-plus','bg-blue-soft text-blue',route('patient.appointments'),'Weka Miadi'],
                            ['fa-file-prescription','bg-green-soft text-green',route('patient.prescriptions'),'Maagizo Yangu'],
                            ['fa-flask-vial','bg-cyan-soft text-cyan',route('patient.lab-results'),'Matokeo ya Lab'],
                            ['fa-receipt','bg-amber-soft text-amber',route('patient.bills'),'Bili Zangu'],
                            ['fa-notes-medical','bg-violet-soft text-violet',route('patient.medical-history'),'Historia ya Matibabu'],
                        ] as [$icon,$cls,$href,$label])
                        <a href="{{ $href }}" class="quick-action-item">
                            <div class="qa-icon {{ $cls }}"><i class="fa-solid {{ $icon }}"></i></div>
                            <span>{{ $label }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Health Tip --}}
                <div class="dash-chart-card" style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);border:none;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-2 text-green"><i class="fa-solid fa-heart-pulse me-2"></i>Ushauri wa Afya</h6>
                        <p class="small mb-0" style="color:#065f46">Kumbuka kuchukua dawa zako kwa wakati na kuhudhuria miadi yote iliyopangwa kwa matokeo bora ya afya yako.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
