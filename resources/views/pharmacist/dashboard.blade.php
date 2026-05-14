@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="pharmacist-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#4c1d95 0%,#7c3aed 60%,#a78bfa 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-pills"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-mortar-pestle"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Mfamasia</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Maagizo leo: <strong>{{ $stats['today_prescriptions'] }}</strong> &bull; Dawa Chache: <strong>{{ $stats['low_stock'] }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-violet h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-violet"><i class="fa-solid fa-pills"></i></div>
                        <div>
                            <div class="stat-label">Jumla ya Dawa</div>
                            <div class="stat-value" data-count="{{ $stats['total_medicines'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-rose h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-rose"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div>
                            <div class="stat-label">Dawa Chache (Low Stock)</div>
                            <div class="stat-value" data-count="{{ $stats['low_stock'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-file-prescription"></i></div>
                        <div>
                            <div class="stat-label">Maagizo Leo</div>
                            <div class="stat-value" data-count="{{ $stats['today_prescriptions'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-cart-flatbed"></i></div>
                        <div>
                            <div class="stat-label">Maagizo Yanayosubiri</div>
                            <div class="stat-value" data-count="{{ $stats['pending_orders'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent Prescriptions --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-receipt me-2 text-violet"></i>Maagizo ya Hivi Karibuni</h6>
                        <a href="{{ route('pharmacist.prescriptions') }}" class="btn btn-sm btn-light fw-semibold px-3">Zote</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Mgonjwa</th>
                                <th>Daktari</th>
                                <th>Stoki</th>
                                <th>Tarehe</th>
                                <th class="text-end pe-3">Kitendo</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recent_prescriptions as $presc)
                                @php $qty = $presc->medicine->quantity ?? 0; @endphp
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-violet-soft text-violet">{{ strtoupper(substr($presc->patient->name ?? 'P',0,1)) }}</div>
                                            <div>
                                                <div class="fw-semibold small">{{ $presc->patient->name ?? 'N/A' }}</div>
                                                <div class="text-muted" style="font-size:.7rem">#PT-{{ $presc->patient_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small fw-semibold">Dkt. {{ $presc->doctor->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="status-badge {{ $qty > 0 ? 'bg-green-soft text-green' : 'bg-rose-soft text-rose' }}">
                                            {{ $qty }} {{ $presc->medicine->unit ?? 'pcs' }}
                                        </span>
                                    </td>
                                    <td class="small text-muted">{{ $presc->created_at->format('d M Y') }}</td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('pharmacist.prescriptions.dispense', $presc->id) }}"
                                            class="btn btn-sm fw-semibold px-3 rounded-2" style="background:#7c3aed;color:#fff">
                                            Toa Dawa
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-prescription-bottle fs-2 opacity-25 d-block mb-2"></i>Hakuna maagizo
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Stock Donut --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-donut me-2 text-violet"></i>Hali ya Stoki</h6></div>
                    <div class="card-body"><canvas id="stockChart" height="195"></canvas></div>
                </div>

                {{-- Low Stock Alerts --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold text-rose"><i class="fa-solid fa-bell me-2"></i>Dawa Chache</h6></div>
                    <div class="card-body pt-3">
                        @forelse($low_stock_items as $item)
                        <div class="activity-item">
                            <div class="activity-dot bg-rose-soft" style="background:#f43f5e !important;width:8px;height:8px;flex-shrink:0;margin-top:6px;"></div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $item->name }}</div>
                                <div class="text-rose" style="font-size:.72rem;font-weight:700">
                                    Iliyobaki: {{ $item->quantity }} {{ $item->unit ?? 'pcs' }}
                                </div>
                            </div>
                            <a href="{{ route('pharmacist.inventory') }}" class="btn btn-sm btn-light border-0 rounded-2 px-2">
                                <i class="fa-solid fa-cart-plus text-violet"></i>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-circle-check fs-2 opacity-25 text-green d-block mb-2"></i>
                            <p class="text-muted small mb-0">Dawa zote zipo vizuri</p>
                        </div>
                        @endforelse
                        <a href="{{ route('pharmacist.inventory') }}" class="btn btn-light fw-semibold w-100 rounded-2 mt-3">
                            <i class="fa-solid fa-boxes-stacked me-2"></i>Simamia Stoki
                        </a>
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
    const ctx = document.getElementById('stockChart');
    if (ctx) {
        const total = {{ $stats['total_medicines'] }};
        const low   = {{ $stats['low_stock'] }};
        const ok    = Math.max(0, total - low);
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Vizuri','Chache (Low Stock)'],
                datasets: [{ data: [ok, low],
                    backgroundColor: ['#10b981','#f43f5e'],
                    borderWidth: 0, hoverOffset: 6 }]
            },
            options: { cutout: '68%',
                plugins: { legend: { position: 'bottom', labels: { padding: 14, font: { size: 11 } } } } }
        });
    }
});
</script>
@endpush
@endsection
