@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="lab-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#1e1b4b 0%,#4f46e5 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-microscope"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-flask-vial"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Mtaalamu wa Maabara</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Zinasubiri: <strong>{{ $stats['pending_requests'] }}</strong> &bull; Zimekamilika leo: <strong>{{ $stats['completed_today'] }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-violet h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-violet"><i class="fa-solid fa-flask-vial"></i></div>
                        <div>
                            <div class="stat-label">Zinasubiri</div>
                            <div class="stat-value" data-count="{{ $stats['pending_requests'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-spinner"></i></div>
                        <div>
                            <div class="stat-label">Zinashughulikiwa</div>
                            <div class="stat-value" data-count="{{ $stats['processing_requests'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-check-double"></i></div>
                        <div>
                            <div class="stat-label">Zimekamilika Leo</div>
                            <div class="stat-value" data-count="{{ $stats['completed_today'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-microscope"></i></div>
                        <div>
                            <div class="stat-label">Jumla ya Vipimo</div>
                            <div class="stat-value" data-count="{{ $stats['total_tests'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Pending Samples Table --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-violet"></i>Maombi ya Lab Yanayosubiri</h6>
                        <a href="{{ route('lab.requests') }}" class="btn btn-sm btn-light fw-semibold px-3">Yote</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Mgonjwa</th>
                                <th>Daktari</th>
                                <th>Vipimo</th>
                                <th class="text-end pe-3">Kitendo</th>
                            </tr></thead>
                            <tbody>
                                @forelse($pending_samples as $sample)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-violet-soft text-violet">{{ strtoupper(substr($sample->patient->name ?? 'P',0,1)) }}</div>
                                            <div>
                                                <div class="fw-semibold small">{{ $sample->patient->name ?? 'N/A' }}</div>
                                                <div class="text-muted" style="font-size:.7rem">#PT-{{ $sample->patient_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-semibold">Dkt. {{ $sample->doctor->name ?? 'N/A' }}</td>
                                    <td><span class="status-badge bg-violet-soft text-violet">{{ $sample->test_names }}</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm fw-semibold px-3 rounded-2" style="background:#4f46e5;color:#fff">Endelea</button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-flask-vial fs-2 opacity-25 d-block mb-2"></i>Hakuna maombi yanayosubiri
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Status Donut --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-donut me-2 text-violet"></i>Hali ya Maombi</h6></div>
                    <div class="card-body"><canvas id="labStatusChart" height="200"></canvas></div>
                </div>
                {{-- Quick Tools --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Zana za Haraka</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-vial','bg-violet-soft text-violet',route('lab.requests'),'Simamia Maombi'],
                            ['fa-microscope','bg-cyan-soft text-cyan',route('lab.equipment'),'Vifaa vya Lab'],
                            ['fa-clipboard-list','bg-amber-soft text-amber',route('lab.tests'),'Orodha ya Vipimo'],
                            ['fa-user','bg-blue-soft text-blue',route('lab.profile'),'Wasifu Wangu'],
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
    const ctx = document.getElementById('labStatusChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Zinasubiri','Zinashughulikiwa','Zimekamilika'],
                datasets: [{ data: [
                    {{ $stats['pending_requests'] }},
                    {{ $stats['processing_requests'] }},
                    {{ $stats['completed_today'] }}
                ], backgroundColor: ['#f59e0b','#4f46e5','#10b981'], borderWidth: 0, hoverOffset: 6 }]
            },
            options: { cutout: '68%', plugins: { legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } } } }
        });
    }
});
</script>
@endpush
@endsection
