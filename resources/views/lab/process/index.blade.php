@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-flask me-2 text-amber"></i>Ombi la Majaribio ya Lab</h4>
            <p class="text-muted small mb-0">Orodha ya ombi zilizo wazi (pending/processing)</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @foreach([
            ['fa-clock','amber','Inasubiri',$stats['pending']],
            ['fa-spinner','blue','Inachakatwa',$stats['processing']],
            ['fa-check','green','Imekamilika Leo',$stats['completed_today']],
            ['fa-triangle-exclamation','rose','Urgent/Emergency',$stats['urgent']],
        ] as [$icon,$color,$label,$value])
        <div class="col">
            <div class="stat-card-modern stat-card-{{ $color }}">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-{{ $color }}"><i class="fa-solid {{ $icon }}"></i></div>
                    <div>
                        <div class="stat-label">{{ $label }}</div>
                        <div class="stat-value">{{ $value }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Requests Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-amber"></i>Ombi Zilizo Wazi</h6>
            <input type="text" id="rSearch" class="form-control form-control-sm" placeholder="Tafuta jina..." style="width:200px">
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="reqTable">
                <thead><tr>
                    <th class="ps-3">Mgonjwa</th>
                    <th>Daktari</th>
                    <th>Majaribio</th>
                    <th>Kipaumbele</th>
                    <th>Hali</th>
                    <th class="text-end pe-3">Vitendo</th>
                </tr></thead>
                <tbody>
                    @forelse($requests as $r)
                    <tr data-id="{{ $r->id }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($r->patient->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $r->patient->name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $r->appointment->patient->patient_number ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">Dkt. {{ $r->doctor->name ?? 'N/A' }}</td>
                        <td class="small text-muted" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $r->test_names }}
                        </td>
                        <td><span class="status-badge {{ $r->priority_badge }}">{{ ucfirst($r->priority) }}</span></td>
                        <td><span class="status-badge {{ $r->status_badge }}">{{ ucfirst($r->status) }}</span></td>
                        <td class="text-end pe-3">
                            <a href="{{ route('lab.process.show', $r) }}" class="btn btn-sm btn-primary rounded-2 px-3">
                                <i class="fa-solid fa-eye me-1"></i>Angalia
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-flask fs-2 opacity-25 d-block mb-2"></i>Hakuna ombi zilizo wazi
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    $('#rSearch').on('input', function () {
        const q = $(this).val().toLowerCase();
        $('#reqTable tbody tr').each(function () {
            const txt = $(this).text().toLowerCase();
            $(this).toggle(!q || txt.includes(q));
        });
    });
});
</script>
@endpush
@endsection
