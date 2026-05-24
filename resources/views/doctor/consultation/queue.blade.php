@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-user-doctor me-2 text-blue"></i>Foleni Yangu — Leo</h4>
            <p class="text-muted small mb-0">Wagonjwa wanaosubiri kuona mimi leo</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @foreach([
            ['fa-user-check','blue','Kwa Mimi Sasa',$stats['with_me']],
            ['fa-flask','amber','Lab Inasubiri',$stats['lab_pending']],
            ['fa-flask-vial','cyan','Lab Imekamilika',$stats['lab_done']],
            ['fa-circle-check','green','Wamekamilika',$stats['completed']],
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

    {{-- Queue Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-blue"></i>Foleni</h6>
            <input type="text" id="qSearch" class="form-control form-control-sm" placeholder="Tafuta jina..." style="width:200px">
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="queueTable">
                <thead><tr>
                    <th class="ps-3">Mgonjwa</th>
                    <th>Q#</th>
                    <th>Hatua</th>
                    <th>Muda</th>
                    <th class="text-end pe-3">Vitendo</th>
                </tr></thead>
                <tbody>
                    @forelse($queue as $appt)
                    <tr data-id="{{ $appt->id }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($appt->patient->display_name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $appt->patient->display_name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $appt->patient->patient_number ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">{{ $appt->queue_number ?? '—' }}</td>
                        <td><span class="status-badge {{ $appt->stage_badge }}">{{ $appt->stage_label }}</span></td>
                        <td class="small text-muted">{{ $appt->appointment_date->format('H:i') }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('doctor.consultation.show', $appt) }}" class="btn btn-sm btn-primary rounded-2 px-3">
                                <i class="fa-solid fa-stethoscope me-1"></i>Angalia
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-doctor fs-2 opacity-25 d-block mb-2"></i>Hakuna mgonjwa kwenye foleni
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
    $('#qSearch').on('input', function () {
        const q = $(this).val().toLowerCase();
        $('#queueTable tbody tr').each(function () {
            const txt = $(this).text().toLowerCase();
            $(this).toggle(!q || txt.includes(q));
        });
    });
});
</script>
@endpush
@endsection
