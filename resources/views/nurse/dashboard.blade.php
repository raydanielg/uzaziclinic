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
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Muuguzi</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Wagonjwa leo: <strong>{{ $stats['today_patients'] }}</strong> &bull; Foleni: <strong>{{ $stats['waiting_queue'] }}</strong></p>
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
                            <div class="stat-label">Wagonjwa Leo</div>
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
                            <div class="stat-label">Wanaongoja</div>
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
                            <div class="stat-label">Vitanda Vilivyojaa</div>
                            <div class="stat-value" data-count="{{ $stats['occupied_beds'] }}">0</div>
                            <div class="stat-trend text-muted">kati ya {{ $stats['total_beds'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-flask"></i></div>
                        <div>
                            <div class="stat-label">Lab Zinasubiri</div>
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
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-users me-2 text-green"></i>Wagonjwa Waliosajiliwa Karibuni</h6>
                        <a href="{{ route('nurse.patients') }}" class="btn btn-sm btn-light fw-semibold px-3">Wote</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Mgonjwa</th>
                                <th>Simu</th>
                                <th>Tarehe</th>
                                <th class="text-end pe-3">Kitendo</th>
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
                                    <i class="fa-solid fa-user-slash fs-2 opacity-25 d-block mb-2"></i>Hakuna wagonjwa
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
                                <p class="mb-0 opacity-75 small fw-semibold text-white text-uppercase">Hali ya Wodi</p>
                                <h5 class="mb-0 fw-bold text-white">
                                    @php $pct = $stats['total_beds'] > 0 ? round($stats['occupied_beds']/$stats['total_beds']*100) : 0; @endphp
                                    {{ $pct }}% Imejaa
                                </h5>
                            </div>
                            <i class="fa-solid fa-hospital-user text-white opacity-25 fs-2"></i>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        @foreach([
                            ['Wodi ya Kawaida','#10b981',90,'18/20'],
                            ['Wodi ya Uzazi','#3b82f6',80,'12/15'],
                            ['ICU / Dharura','#f59e0b',40,'4/10'],
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
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Zana za Haraka</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-user-plus','bg-blue-soft text-blue',route('nurse.checkin'),'Check-in Mgonjwa'],
                            ['fa-list-ol','bg-amber-soft text-amber',route('nurse.queue'),'Angalia Foleni'],
                            ['fa-flask-vial','bg-cyan-soft text-cyan',route('nurse.lab-collection'),'Sampuli za Lab'],
                            ['fa-bed-pulse','bg-green-soft text-green',route('nurse.bed-allocation'),'Ugawaji Vitanda'],
                            ['fa-pills','bg-violet-soft text-violet',route('nurse.medication'),'Dawa'],
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
