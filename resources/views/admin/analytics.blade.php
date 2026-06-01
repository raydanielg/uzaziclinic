@extends('layouts.admin')

@section('page_title', 'Analytics Dashboard')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Analytics Dashboard</h4>
            <p class="text-muted small mb-0">Uzazi Clinic — Takwimu za Kweli</p>
        </div>
        <div class="col-auto">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-2">
                <i class="fa-solid fa-clock me-1"></i>{{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-2 p-3">
                        <i class="fa-solid fa-users text-white fs-4"></i>
                    </div>
                    <div class="text-white">
                        <div class="small text-white-50">Wagonjwa Jumla</div>
                        <div class="fw-bold fs-4">{{ number_format($totalPatients) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100" style="background:linear-gradient(135deg,#10b981,#059669);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-2 p-3">
                        <i class="fa-solid fa-user-doctor text-white fs-4"></i>
                    </div>
                    <div class="text-white">
                        <div class="small text-white-50">Madaktari</div>
                        <div class="fw-bold fs-4">{{ $totalDoctors }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-2 p-3">
                        <i class="fa-solid fa-calendar-check text-white fs-4"></i>
                    </div>
                    <div class="text-white">
                        <div class="small text-white-50">Miadi Jumla</div>
                        <div class="fw-bold fs-4">{{ number_format($totalAppointments) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-2 p-3">
                        <i class="fa-solid fa-money-bill-wave text-white fs-4"></i>
                    </div>
                    <div class="text-white">
                        <div class="small text-white-50">Mapato (TZS)</div>
                        <div class="fw-bold fs-4">{{ number_format($totalRevenue) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Wagonjwa Leo</div>
                        <div class="fw-bold fs-3 text-primary">{{ $todayPatients }}</div>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-2 p-3">
                        <i class="fa-solid fa-day-calendar fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Mapato Leo (TZS)</div>
                        <div class="fw-bold fs-3 text-success">{{ number_format($todayRevenue) }}</div>
                    </div>
                    <div class="bg-success-subtle text-success rounded-2 p-3">
                        <i class="fa-solid fa-coins fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-chart-area me-2 text-primary"></i>Mwenendo wa Wagonjwa (Miezi 6)</h6>
                <div id="patientsTrendChart" style="height:300px;"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-venus-mars me-2 text-primary"></i>Wagonjwa Kulingana na Jinsia</h6>
                <div id="genderChart" style="height:300px;"></div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-list-check me-2 text-primary"></i>Aina za Miadi</h6>
                <div id="typeChart" style="height:280px;"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-route me-2 text-primary"></i>Hali ya Wagonjwa (Workflow)</h6>
                <div id="stageChart" style="height:280px;"></div>
            </div>
        </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-chart-line me-2 text-success"></i>Mapato Kwa Mwezi (Miezi 6)</h6>
                <div id="revenueChart" style="height:300px;"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-trophy me-2 text-warning"></i>Madaktari 5 Bora</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            @forelse($topDoctors as $idx => $doc)
                            <tr>
                                <td><span class="badge bg-{{ $idx === 0 ? 'warning' : 'light' }} text-{{ $idx === 0 ? 'dark' : 'muted' }} fw-bold">{{ $idx + 1 }}</span></td>
                                <td class="fw-semibold">{{ $doc->display_name }}</td>
                                <td class="text-end text-muted">{{ $doc->appointments_count }} miadi</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted small py-3">Hakuna data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
    <script>
        // PHP data to JS
        const monthlyPatients = @json($monthlyPatients);
        const genderStats = @json($genderStats);
        const typeStats = @json($typeStats);
        const stageStats = @json($stageStats);
        const monthlyRevenue = @json($monthlyRevenue);

        // Patients Trend Chart
        const patientsTrendOptions = {
            series: [{
                name: 'Wagonjwa',
                data: monthlyPatients.map(m => m.count)
            }],
            chart: { height: 300, type: 'area', toolbar: { show: false } },
            colors: ['#3b82f6'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: { categories: monthlyPatients.map(m => m.month) },
            yaxis: { title: { text: 'Idadi' } },
            tooltip: { y: { formatter: (val) => val + ' wagonjwa' } }
        };
        new ApexCharts(document.querySelector("#patientsTrendChart"), patientsTrendOptions).render();

        // Gender Chart
        const genderOptions = {
            series: genderStats.map(g => g.count),
            labels: genderStats.map(g => g.gender === 'male' ? 'Wanaume' : g.gender === 'female' ? 'Wanawake' : 'Wengine'),
            chart: { type: 'donut', height: 300 },
            colors: ['#3b82f6', '#ec4899', '#6b7280'],
            plotOptions: { pie: { donut: { size: '70%' } } },
            dataLabels: { enabled: false },
            legend: { position: 'bottom' }
        };
        new ApexCharts(document.querySelector("#genderChart"), genderOptions).render();

        // Appointment Types Chart
        const typeOptions = {
            series: typeStats.map(t => t.count),
            labels: typeStats.map(t => t.type || 'General'),
            chart: { type: 'pie', height: 280 },
            colors: ['#10b981', '#f59e0b', '#3b82f6', '#8b5cf6', '#ef4444'],
            legend: { position: 'bottom' }
        };
        new ApexCharts(document.querySelector("#typeChart"), typeOptions).render();

        // Stage Workflow Chart
        const stageLabels = {
            'with_doctor': 'Kwa Daktari',
            'awaiting_lab': 'Kwenye Lab',
            'lab_complete': 'Matokeo Lab',
            'awaiting_pharmacy': 'Kwenye Pharmacy',
            'done': 'Imekamilika'
        };
        const stageOptions = {
            series: stageStats.map(s => s.count),
            labels: stageStats.map(s => stageLabels[s.current_stage] || s.current_stage),
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
            colors: ['#3b82f6', '#f59e0b', '#10b981', '#8b5cf6', '#6b7280'],
            dataLabels: { enabled: false },
            xaxis: { categories: stageStats.map(s => stageLabels[s.current_stage] || s.current_stage) }
        };
        new ApexCharts(document.querySelector("#stageChart"), stageOptions).render();

        // Revenue Chart
        const revenueOptions = {
            series: [{
                name: 'Mapato (TZS)',
                data: monthlyRevenue.map(m => m.total)
            }],
            chart: { height: 300, type: 'bar', toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
            colors: ['#10b981'],
            dataLabels: { enabled: false },
            xaxis: { categories: monthlyRevenue.map(m => m.month) },
            yaxis: { labels: { formatter: (val) => (val / 1000000).toFixed(1) + 'M' }, title: { text: 'TZS (Millions)' } },
            tooltip: { y: { formatter: (val) => 'TZS ' + (val).toLocaleString() } }
        };
        new ApexCharts(document.querySelector("#revenueChart"), revenueOptions).render();
    </script>
@endpush
