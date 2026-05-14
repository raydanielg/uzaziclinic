@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0">Miadi Yangu</h4>
            <p class="text-muted small mb-0">Orodha ya miadi yote iliyopangwa kwako</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-blue">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-blue"><i class="fa-solid fa-calendar-day"></i></div>
                    <div>
                        <div class="stat-label">Leo</div>
                        <div class="stat-value">{{ $stats['today'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-amber">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-amber"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <div class="stat-label">Inasubiri</div>
                        <div class="stat-value">{{ $stats['pending'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-green">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-green"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <div class="stat-label">Imethibitishwa</div>
                        <div class="stat-value">{{ $stats['confirmed'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-violet">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-violet"><i class="fa-solid fa-check-double"></i></div>
                    <div>
                        <div class="stat-label">Imekamilika</div>
                        <div class="stat-value">{{ $stats['completed'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-blue"></i>Miadi Yote</h6>
            <div class="d-flex gap-2 flex-wrap">
                <input type="text" id="searchAppt" class="form-control form-control-sm"
                    placeholder="Tafuta mgonjwa..." style="width:200px">
                <select id="filterStatus" class="form-select form-select-sm" style="width:150px">
                    <option value="">Hali Zote</option>
                    <option value="pending">Inasubiri</option>
                    <option value="confirmed">Imethibitishwa</option>
                    <option value="completed">Imekamilika</option>
                    <option value="cancelled">Imefutwa</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="apptTable">
                <thead>
                    <tr>
                        <th class="ps-3">Mgonjwa</th>
                        <th>Tarehe &amp; Muda</th>
                        <th>Aina</th>
                        <th>Dalili</th>
                        <th>Hali</th>
                        <th class="text-end pe-3">Vitendo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    @php
                        $pName = $appt->patient->display_name ?? ($appt->patient->name ?? 'N/A');
                        $st    = $appt->status ?? 'pending';
                        $sc    = match($st) {
                            'confirmed' => ['bg-blue-soft text-blue',  'fa-circle-check'],
                            'completed' => ['bg-green-soft text-green', 'fa-check-double'],
                            'cancelled' => ['bg-rose-soft text-rose',  'fa-circle-xmark'],
                            default     => ['bg-amber-soft text-amber', 'fa-clock'],
                        };
                    @endphp
                    <tr data-id="{{ $appt->id }}" data-status="{{ $st }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($pName, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $pName }}</div>
                                    <div class="text-muted" style="font-size:.7rem">
                                        {{ $appt->patient->patient_number ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $appt->appointment_date->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $appt->appointment_date->format('h:i A') }}</div>
                        </td>
                        <td class="small text-muted">{{ $appt->type ?? 'General' }}</td>
                        <td class="small text-muted" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $appt->symptoms ?? '—' }}
                        </td>
                        <td>
                            <span class="status-badge {{ $sc[0] }}">
                                <i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($st) }}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            @if($st === 'pending')
                            <button class="btn btn-sm btn-light rounded-2 px-2 me-1 confirm-btn"
                                data-id="{{ $appt->id }}" title="Thibitisha">
                                <i class="fa-solid fa-circle-check text-green"></i>
                            </button>
                            @endif
                            @if(in_array($st, ['pending','confirmed']))
                            <button class="btn btn-sm btn-light rounded-2 px-2 me-1 complete-btn"
                                data-id="{{ $appt->id }}" title="Imekamilika">
                                <i class="fa-solid fa-check-double text-blue"></i>
                            </button>
                            @endif
                            <button class="btn btn-sm btn-light rounded-2 px-2 notes-btn"
                                data-id="{{ $appt->id }}"
                                data-diagnosis="{{ $appt->diagnosis ?? '' }}"
                                data-notes="{{ $appt->notes ?? '' }}"
                                title="Maelezo / Utambuzi">
                                <i class="fa-solid fa-notes-medical text-violet"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>Hakuna miadi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
        <div class="px-3 py-2 border-top bg-white">{{ $appointments->links() }}</div>
        @endif
    </div>
</div>

{{-- Notes / Diagnosis Modal --}}
<div class="modal fade" id="notesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h6 class="modal-title fw-bold">
                    <i class="fa-solid fa-notes-medical me-2"></i>Utambuzi &amp; Maelezo
                </h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="notesApptId">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Utambuzi (Diagnosis)</label>
                    <textarea id="notesdiagnosis" class="form-control shadow-none" rows="3"
                        placeholder="Andika utambuzi hapa..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Maelezo (Notes)</label>
                    <textarea id="notesNotes" class="form-control shadow-none" rows="2"
                        placeholder="Maelezo ya ziada..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Badilisha Hali</label>
                    <select id="notesStatus" class="form-select shadow-none">
                        <option value="">-- Usibadilishe --</option>
                        <option value="confirmed">Thibitisha</option>
                        <option value="completed">Imekamilika</option>
                        <option value="cancelled">Futa</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-2">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Funga</button>
                <button type="button" class="btn btn-sm btn-primary" id="saveNotes">
                    <i class="fa-solid fa-save me-1"></i>Hifadhi
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    const CSRF = '{{ csrf_token() }}';

    function updateStatus(id, status, diagnosis, notes) {
        return $.post(`{{ url('doctor/appointments') }}/${id}/status`, {
            _token: CSRF, status, diagnosis, notes
        });
    }

    // ── Confirm ───────────────────────────────────────────────
    $(document).on('click', '.confirm-btn', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Thibitisha Miadi?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ndiyo',
            cancelButtonText: 'Hapana'
        }).then(res => {
            if (!res.isConfirmed) return;
            updateStatus(id, 'confirmed')
                .done(r => {
                    if (r.success) {
                        Swal.fire({ icon: 'success', title: r.message, timer: 1600, showConfirmButton: false })
                            .then(() => location.reload());
                    }
                })
                .fail(() => Swal.fire('Hitilafu', 'Imeshindwa kubadilisha', 'error'));
        });
    });

    // ── Complete ──────────────────────────────────────────────
    $(document).on('click', '.complete-btn', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Imekamilika?',
            text: 'Thibitisha miadi hii imekamilika.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Ndiyo',
            cancelButtonText: 'Hapana'
        }).then(res => {
            if (!res.isConfirmed) return;
            updateStatus(id, 'completed')
                .done(r => {
                    if (r.success) {
                        Swal.fire({ icon: 'success', title: r.message, timer: 1600, showConfirmButton: false })
                            .then(() => location.reload());
                    }
                })
                .fail(() => Swal.fire('Hitilafu', 'Imeshindwa kubadilisha', 'error'));
        });
    });

    // ── Notes Modal ───────────────────────────────────────────
    $(document).on('click', '.notes-btn', function () {
        $('#notesApptId').val($(this).data('id'));
        $('#notesdiagnosis').val($(this).data('diagnosis'));
        $('#notesNotes').val($(this).data('notes'));
        $('#notesStatus').val('');
        new bootstrap.Modal(document.getElementById('notesModal')).show();
    });

    $('#saveNotes').on('click', function () {
        const id        = $('#notesApptId').val();
        const diagnosis = $('#notesdiagnosis').val();
        const notes     = $('#notesNotes').val();
        const status    = $('#notesStatus').val() || 'confirmed';

        updateStatus(id, status, diagnosis, notes)
            .done(r => {
                if (r.success) {
                    bootstrap.Modal.getInstance(document.getElementById('notesModal')).hide();
                    Swal.fire({ icon: 'success', title: r.message, timer: 1600, showConfirmButton: false })
                        .then(() => location.reload());
                }
            })
            .fail(() => Swal.fire('Hitilafu', 'Imeshindwa kuhifadhi', 'error'));
    });

    // ── Search + Filter ───────────────────────────────────────
    function applyFilters() {
        const q  = $('#searchAppt').val().toLowerCase();
        const st = $('#filterStatus').val().toLowerCase();
        $('#apptTable tbody tr').each(function () {
            const text  = $(this).text().toLowerCase();
            const rowSt = ($(this).data('status') ?? '').toLowerCase();
            let show = true;
            if (q && !text.includes(q)) show = false;
            if (st && rowSt !== st) show = false;
            $(this).toggle(show);
        });
    }
    $('#searchAppt, #filterStatus').on('input change', applyFilters);
});
</script>
@endpush
@endsection
