@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-pills me-2 text-violet"></i>Kutolea Dawa (Dispensing)</h4>
            <p class="text-muted small mb-0">Orodha ya prescriptions zilizo pending</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @foreach([
            ['fa-clock','amber','Inasubiri',$stats['pending']],
            ['fa-check','green','Imetolewa Leo',$stats['dispensed_today']],
            ['fa-triangle-exclamation','rose','Stock Chini',$stats['low_stock']],
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

    {{-- Prescriptions Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-violet"></i>Prescriptions Zilizo Pending</h6>
            <input type="text" id="rSearch" class="form-control form-control-sm" placeholder="Tafuta jina..." style="width:200px">
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="rxTable">
                <thead><tr>
                    <th class="ps-3">Mgonjwa</th>
                    <th>Daktari</th>
                    <th>Utambuzi</th>
                    <th>Items</th>
                    <th>Cost</th>
                    <th class="text-end pe-3">Vitendo</th>
                </tr></thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                    <tr data-id="{{ $rx->id }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($rx->patient->display_name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $rx->patient->display_name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $rx->patient->patient_number ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">Dkt. {{ $rx->doctor->display_name ?? 'N/A' }}</td>
                        <td class="small text-muted" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $rx->diagnosis ?? '—' }}
                        </td>
                        <td class="small">{{ $rx->items->count() }}</td>
                        <td class="small">{{ number_format($rx->total_cost, 2) }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('pharmacist.dispense.show', $rx) }}" class="btn btn-sm btn-primary rounded-2 px-3">
                                <i class="fa-solid fa-eye me-1"></i>Angalia
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-pills fs-2 opacity-25 d-block mb-2"></i>Hakuna prescription pending
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
        $('#rxTable tbody tr').each(function () {
            const txt = $(this).text().toLowerCase();
            $(this).toggle(!q || txt.includes(q));
        });
    });
});
</script>
@endpush
@endsection
