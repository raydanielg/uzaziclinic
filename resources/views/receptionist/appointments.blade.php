@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="py-4">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="row mb-4 anim-1">
            <div class="col">
                <h4 class="fw-bold mb-0">Usimamizi wa Miadi</h4>
                <p class="text-muted small mb-0">Weka, thibitisha au futa miadi ya wagonjwa</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2 shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#bookModal">
                    <i class="fa-solid fa-calendar-plus me-2"></i>Weka Miadi
                </button>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="row g-3 mb-4 anim-2">
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-blue">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-calendar-day"></i></div>
                        <div><div class="stat-label">Leo</div>
                        <div class="stat-value">{{ \App\Models\Appointment::whereDate('appointment_date', today())->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-amber">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-clock"></i></div>
                        <div><div class="stat-label">Inasubiri</div>
                        <div class="stat-value">{{ $appointments->where('status','pending')->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-green">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-circle-check"></i></div>
                        <div><div class="stat-label">Imethibitishwa</div>
                        <div class="stat-value">{{ $appointments->where('status','confirmed')->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-cyan">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-list-check"></i></div>
                        <div><div class="stat-label">Jumla</div>
                        <div class="stat-value">{{ $appointments->total() }}</div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="dash-table-card anim-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-blue"></i>Miadi Yote</h6>
                <div class="d-flex gap-2">
                    <select id="filterStatus" class="form-select form-select-sm" style="width:150px">
                        <option value="">Hali Zote</option>
                        <option value="pending">Inasubiri</option>
                        <option value="confirmed">Imethibitishwa</option>
                        <option value="completed">Imekamilika</option>
                        <option value="cancelled">Imefutwa</option>
                    </select>
                    <input type="date" id="filterDate" class="form-control form-control-sm" style="width:160px" value="{{ date('Y-m-d') }}">
                    <button class="btn btn-sm btn-light" id="clearFilter"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="apptTable">
                    <thead><tr>
                        <th class="ps-3">#</th>
                        <th>Mgonjwa</th>
                        <th>Daktari</th>
                        <th>Tarehe &amp; Muda</th>
                        <th>Aina</th>
                        <th>Hali</th>
                        <th class="text-end pe-3">Vitendo</th>
                    </tr></thead>
                    <tbody id="apptBody">
                        @forelse($appointments as $appt)
                        @php
                            $patientName = $appt->patient->display_name ?? $appt->patient->name ?? 'N/A';
                            $doctorName  = $appt->doctor->display_name ?? 'N/A';
                            $st = $appt->status ?? 'pending';
                            $sc = match($st) {
                                'confirmed' => ['bg-blue-soft text-blue','fa-circle-check'],
                                'completed' => ['bg-green-soft text-green','fa-check-double'],
                                'cancelled' => ['bg-rose-soft text-rose','fa-circle-xmark'],
                                default     => ['bg-amber-soft text-amber','fa-clock'],
                            };
                        @endphp
                        <tr data-id="{{ $appt->id }}" data-status="{{ $st }}">
                            <td class="ps-3 text-muted small">#{{ $appt->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar bg-blue-soft text-blue">{{ strtoupper(substr($patientName,0,1)) }}</div>
                                    <div>
                                        <div class="fw-semibold small">{{ $patientName }}</div>
                                        <div class="text-muted" style="font-size:.7rem">{{ $appt->patient->phone ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small fw-semibold">Dkt. {{ $doctorName }}</td>
                            <td>
                                <div class="fw-semibold small">{{ $appt->appointment_date->format('d M Y') }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $appt->appointment_date->format('H:i') }}</div>
                            </td>
                            <td class="small text-muted">{{ $appt->type ?? 'General' }}</td>
                            <td>
                                <span class="status-badge {{ $sc[0] }} appt-status-badge">
                                    <i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($st) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                @if($st === 'pending')
                                <button class="btn btn-sm btn-light me-1 confirm-btn rounded-2 px-2" data-id="{{ $appt->id }}" title="Thibitisha">
                                    <i class="fa-solid fa-check text-green"></i>
                                </button>
                                @endif
                                @if(in_array($st, ['pending','confirmed']))
                                <button class="btn btn-sm btn-light me-1 complete-btn rounded-2 px-2" data-id="{{ $appt->id }}" title="Imekamilika">
                                    <i class="fa-solid fa-check-double text-blue"></i>
                                </button>
                                <button class="btn btn-sm btn-light cancel-btn rounded-2 px-2" data-id="{{ $appt->id }}" title="Futa">
                                    <i class="fa-solid fa-times text-rose"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-calendar-xmark fs-2 d-block mb-2 opacity-25"></i>
                            Hakuna miadi
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments->hasPages())
            <div class="px-3 py-2 border-top bg-white">{{ $appointments->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Book Appointment Modal --}}
<div class="modal fade" id="bookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0" style="background:linear-gradient(135deg,#2563eb,#06b6d4);">
                <h5 class="modal-title fw-bold text-white"><i class="fa-solid fa-calendar-plus me-2"></i>Weka Miadi Mpya</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Mgonjwa <span class="text-danger">*</span></label>
                            <select name="patient_id" class="form-select shadow-none" required>
                                <option value="">-- Chagua Mgonjwa --</option>
                                @foreach($patients as $p)
                                <option value="{{ $p->id }}">
                                    PT-{{ str_pad($p->id,3,'0',STR_PAD_LEFT) }} | {{ $p->display_name }} ({{ $p->phone ?? '---' }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Daktari <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-select shadow-none" required>
                                <option value="">-- Chagua Daktari --</option>
                                @foreach($doctors as $d)
                                <option value="{{ $d->id }}">
                                    Dkt. {{ $d->user->name }} — {{ $d->specialization ?? 'General' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Aina ya Miadi</label>
                            <select name="type" class="form-select shadow-none">
                                <option value="General Consultation">Ushauri wa Jumla</option>
                                <option value="Follow-up">Ufuatiliaji</option>
                                <option value="Emergency">Dharura</option>
                                <option value="Lab Test">Kipimo cha Lab</option>
                                <option value="Specialist">Mtaalamu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tarehe <span class="text-danger">*</span></label>
                            <input type="date" name="appointment_date" class="form-control shadow-none" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Muda <span class="text-danger">*</span></label>
                            <input type="time" name="appointment_time" class="form-control shadow-none" required value="09:00">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Maelezo / Dalili</label>
                            <textarea name="notes" class="form-control shadow-none" rows="2" placeholder="Sababu ya ziara au maelezo maalum..."></textarea>
                        </div>
                    </div>
                    <div id="bookErrors" class="alert alert-danger mt-3 d-none small"></div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light rounded-2" data-bs-dismiss="modal">Funga</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4" id="bookBtn">
                        <span id="bookBtnText"><i class="fa-solid fa-save me-2"></i>Weka Miadi</span>
                        <span id="bookBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const CSRF = '{{ csrf_token() }}';

    // ── Book Appointment ─────────────────────────────────────
    $('#bookForm').on('submit', function(e) {
        e.preventDefault();
        $('#bookErrors').addClass('d-none');
        $('#bookBtnText').addClass('d-none');
        $('#bookBtnSpinner').removeClass('d-none');

        $.ajax({
            url: '{{ route("receptionist.appointments.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp.success) {
                    Swal.fire({icon:'success',title:'Imefanikiwa!',text:resp.message,timer:2000,showConfirmButton:false})
                        .then(() => location.reload());
                }
            },
            error: function(xhr) {
                $('#bookBtnText').removeClass('d-none');
                $('#bookBtnSpinner').addClass('d-none');
                const errs = xhr.responseJSON?.errors;
                let msg = xhr.responseJSON?.message ?? 'Kuna hitilafu. Jaribu tena.';
                if (errs) msg = Object.values(errs).flat().join('<br>');
                $('#bookErrors').html(msg).removeClass('d-none');
            }
        });
    });

    // ── Confirm ──────────────────────────────────────────────
    $(document).on('click', '.confirm-btn', function() {
        updateStatus($(this).data('id'), 'confirmed', $(this).closest('tr'));
    });

    // ── Complete ─────────────────────────────────────────────
    $(document).on('click', '.complete-btn', function() {
        updateStatus($(this).data('id'), 'completed', $(this).closest('tr'));
    });

    // ── Cancel ───────────────────────────────────────────────
    $(document).on('click', '.cancel-btn', function() {
        const id = $(this).data('id');
        const $row = $(this).closest('tr');
        Swal.fire({
            title: 'Futa Miadi?',
            text: 'Una uhakika unataka kufuta miadi hii?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ndiyo, Futa!',
            cancelButtonText: 'Hapana'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('receptionist/appointments') }}/${id}`,
                    method: 'POST',
                    data: { _token: CSRF, _method: 'DELETE' },
                    success: function(resp) {
                        if (resp.success) {
                            applyStatusBadge($row, 'cancelled');
                            $row.find('.confirm-btn,.complete-btn,.cancel-btn').remove();
                            Swal.fire({icon:'success',title:'Imefutwa!',text:resp.message,timer:1800,showConfirmButton:false});
                        }
                    },
                    error: () => Swal.fire('Hitilafu','Imeshindwa kufuta','error')
                });
            }
        });
    });

    function updateStatus(id, status, $row) {
        const label = { confirmed:'thibitisha', completed:'kamilisha' }[status] ?? status;
        Swal.fire({
            title: 'Badilisha Hali?',
            text: `Una uhakika unataka ${label} miadi hii?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ndiyo',
            cancelButtonText: 'Hapana'
        }).then(result => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: `{{ url('receptionist/appointments') }}/${id}/status`,
                method: 'POST',
                data: { _token: CSRF, status: status },
                success: function(resp) {
                    if (resp.success) {
                        applyStatusBadge($row, status);
                        if (status === 'confirmed') { $row.find('.confirm-btn').remove(); }
                        if (status === 'completed') { $row.find('.confirm-btn,.complete-btn,.cancel-btn').remove(); }
                        Swal.fire({icon:'success',title:'Imebadilishwa!',text:resp.message,timer:1600,showConfirmButton:false});
                    }
                },
                error: () => Swal.fire('Hitilafu','Imeshindwa kubadilisha hali','error')
            });
        });
    }

    function applyStatusBadge($row, status) {
        const map = {
            confirmed: ['bg-blue-soft text-blue','fa-circle-check','Confirmed'],
            completed: ['bg-green-soft text-green','fa-check-double','Completed'],
            cancelled: ['bg-rose-soft text-rose','fa-circle-xmark','Cancelled'],
            pending:   ['bg-amber-soft text-amber','fa-clock','Pending'],
        };
        const [cls, icon, label] = map[status] ?? map.pending;
        $row.find('.appt-status-badge')
            .attr('class', `status-badge ${cls} appt-status-badge`)
            .html(`<i class="fa-solid ${icon} me-1"></i>${label}`);
    }

    // ── Client-side filter ────────────────────────────────────
    function applyFilters() {
        const st = $('#filterStatus').val().toLowerCase();
        const dt = $('#filterDate').val();
        $('#apptBody tr').each(function() {
            const rowStatus = $(this).data('status') ?? '';
            const rowDate   = $(this).find('td:eq(3)').text().trim();
            let show = true;
            if (st && rowStatus !== st) show = false;
            if (dt) {
                const d = new Date(dt);
                const label = d.toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'});
                if (!rowDate.includes(label)) show = false;
            }
            $(this).toggle(show);
        });
    }

    $('#filterStatus, #filterDate').on('change', applyFilters);
    $('#clearFilter').on('click', function() {
        $('#filterStatus').val('');
        $('#filterDate').val('');
        $('#apptBody tr').show();
    });
});
</script>
@endpush
@endsection
