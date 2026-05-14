@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="accountant-dashboard py-4">
    <div class="container-fluid">

        {{-- Hero --}}
        <div class="row mb-4 anim-1">
            <div class="col-12">
                <div class="dash-hero-card" style="background:linear-gradient(135deg,#064e3b 0%,#047857 50%,#10b981 100%);">
                    <div class="hero-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="user-avatar bg-white bg-opacity-20 text-white fs-5">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div>
                            <p class="mb-0 opacity-75 small fw-semibold text-uppercase">Mhasibu</p>
                            <h4 class="mb-0 fw-bold">Karibu, {{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <p class="mb-0 opacity-75 small">{{ now()->format('l, d F Y') }} &bull; Makusanyo leo: <strong>TZS {{ number_format($stats['today_payments']) }}</strong></p>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 anim-2">
                <div class="stat-card-modern stat-card-green h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-money-bill-trend-up"></i></div>
                        <div>
                            <div class="stat-label">Jumla ya Mapato</div>
                            <div class="stat-value" style="font-size:1.3rem" data-count="{{ $stats['total_revenue'] }}" data-prefix="TZS ">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-3">
                <div class="stat-card-modern stat-card-amber h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <div>
                            <div class="stat-label">Ankara Zinazosubiri</div>
                            <div class="stat-value" data-count="{{ $stats['pending_invoices'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-4">
                <div class="stat-card-modern stat-card-blue h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        <div>
                            <div class="stat-label">Makusanyo Leo</div>
                            <div class="stat-value" style="font-size:1.3rem" data-count="{{ $stats['today_payments'] }}" data-prefix="TZS ">0</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 anim-5">
                <div class="stat-card-modern stat-card-cyan h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-receipt"></i></div>
                        <div>
                            <div class="stat-label">Jumla ya Ankara</div>
                            <div class="stat-value" data-count="{{ $stats['total_invoices'] }}">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Recent Payments Table --}}
            <div class="col-lg-8 anim-5">
                <div class="dash-table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fa-solid fa-money-bill-wave me-2 text-green"></i>Malipo ya Hivi Karibuni</h6>
                        <a href="{{ route('accountant.payments') }}" class="btn btn-sm btn-light fw-semibold px-3">Yote</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr>
                                <th class="ps-3">Ankara #</th>
                                <th>Mgonjwa</th>
                                <th>Kiasi</th>
                                <th class="text-end pe-3">Tarehe</th>
                            </tr></thead>
                            <tbody>
                                @forelse($recent_payments as $payment)
                                <tr>
                                    <td class="ps-3 fw-bold text-green">#INV-{{ $payment->invoice_id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar bg-green-soft text-green">{{ strtoupper(substr($payment->invoice->patient->name ?? 'P',0,1)) }}</div>
                                            <span class="small fw-semibold">{{ $payment->invoice->patient->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-green small">TZS {{ number_format($payment->amount) }}</td>
                                    <td class="text-end pe-3 small text-muted">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-receipt fs-2 opacity-25 d-block mb-2"></i>Hakuna malipo ya hivi karibuni
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="col-lg-4 anim-6">
                {{-- Revenue Chart --}}
                <div class="dash-chart-card mb-4">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-chart-line me-2 text-green"></i>Mapato ya Wiki</h6></div>
                    <div class="card-body"><canvas id="revenueChart" height="185"></canvas></div>
                </div>
                {{-- Quick Actions --}}
                <div class="dash-chart-card">
                    <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-bolt me-2 text-amber"></i>Vitendo vya Haraka</h6></div>
                    <div class="card-body d-flex flex-column gap-2 pt-3">
                        @foreach([
                            ['fa-file-invoice','bg-amber-soft text-amber',route('accountant.invoices'),'Simamia Ankara'],
                            ['fa-money-bill-wave','bg-green-soft text-green',route('accountant.payments'),'Angalia Malipo'],
                            ['fa-chart-bar','bg-blue-soft text-blue',route('accountant.reports'),'Ripoti za Fedha'],
                            ['fa-user','bg-violet-soft text-violet',route('accountant.profile'),'Wasifu Wangu'],
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
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jum','Jtatu','Jua','Alh','Iju','Jumam','Jmap'],
                datasets: [{
                    label: 'Mapato (TZS)',
                    data: [45000,72000,38000,91000,63000,28000,55000],
                    borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true, tension: 0.4, pointRadius: 4,
                    pointBackgroundColor: '#10b981', pointHoverRadius: 6
                }]
            },
            options: { responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' },
                    ticks: { callback: v => 'TZS '+v.toLocaleString() } },
                    x: { grid: { display: false } } } }
        });
    }
});
</script>
@endpush
@endsection
