@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-users-line me-2 text-blue"></i>Patient Queue — Today</h4>
            <p class="text-muted small mb-0">{{ now()->format('l, d F Y') }} · Receive patient, register, and send to doctor</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary fw-semibold rounded-2 shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#newVisitModal">
                <i class="fa-solid fa-user-plus me-2"></i>Receive Patient
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @foreach([
            ['fa-users','blue','Total',$stats['total']],
            ['fa-stethoscope','blue','With Doctor',$stats['with_doctor']],
            ['fa-flask','amber','Awaiting Lab',$stats['awaiting_lab']],
            ['fa-pills','violet','Awaiting Pharmacy',$stats['awaiting_pharmacy']],
            ['fa-circle-check','green','Completed',$stats['done']],
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
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-blue"></i>Current Queue</h6>
            <div class="d-flex gap-2">
                <input type="text" id="qSearch" class="form-control form-control-sm" placeholder="Search name or number..." style="width:200px">
                <select id="qDoctor" class="form-select form-select-sm" style="width:170px">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $d)
                    <option value="{{ $d->id }}">Dr. {{ $d->display_name }}</option>
                    @endforeach
                </select>
                <select id="qStage" class="form-select form-select-sm" style="width:170px">
                    <option value="">All Stages</option>
                    @foreach(\App\Models\Appointment::STAGES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="queueTable">
                <thead><tr>
                    <th class="ps-3">Q#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Type</th>
                    <th>Stage</th>
                    <th>Time</th>
                    <th class="text-end pe-3">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($visits as $v)
                    <tr data-stage="{{ $v->current_stage }}" data-id="{{ $v->id }}">
                        <td class="ps-3 fw-bold">{{ $v->queue_number ?? '—' }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($v->patient->display_name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $v->patient->display_name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $v->patient->patient_number ?? '' }} · {{ $v->patient->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            @if($v->doctor)
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-green-soft text-green" style="width:28px;height:28px;font-size:.7rem">
                                    {{ strtoupper(substr($v->doctor->display_name ?? '?', 0, 1)) }}
                                </div>
                                <span>Dr. {{ $v->doctor->display_name }}</span>
                            </div>
                            @else
                            <span class="text-muted">Not Assigned</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $v->type ?? 'General' }}</td>
                        <td><span class="status-badge {{ $v->stage_badge }}">{{ $v->stage_label }}</span></td>
                        <td class="small text-muted">{{ $v->appointment_date->format('H:i') }}</td>
                        <td class="text-end pe-3">
                            @if(!in_array($v->status, ['cancelled','completed']))
                            <button class="btn btn-sm btn-light rounded-2 cancel-visit" data-id="{{ $v->id }}" title="Cancel">
                                <i class="fa-solid fa-xmark text-rose"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fs-2 opacity-25 d-block mb-2"></i>No patients in queue today
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────────────────────
     New Visit Modal — Search/Register patient → Send to doctor
     ───────────────────────────────────────────────────────── --}}
<div class="modal fade" id="newVisitModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Receive New Patient</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                {{-- Step 1: Find or register --}}
                <div id="stepFind">
                    <ul class="nav nav-pills nav-fill mb-3 small" id="patientTabs">
                        <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="pill" data-bs-target="#tabExisting"><i class="fa-solid fa-magnifying-glass me-1"></i>Existing Patient</button></li>
                        <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#tabNew"><i class="fa-solid fa-user-plus me-1"></i>New Patient</button></li>
                    </ul>

                    <div class="tab-content">
                        {{-- Existing --}}
                        <div class="tab-pane fade show active" id="tabExisting">
                            <label class="form-label small fw-bold">Search by Name, Phone or Number (PT-001)</label>
                            <input type="text" id="patientSearch" class="form-control shadow-none" placeholder="Type name or phone...">
                            <div id="searchResults" class="mt-2" style="max-height:280px;overflow-y:auto"></div>
                        </div>

                        {{-- New --}}
                        <div class="tab-pane fade" id="tabNew">
                            <form id="registerForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Jina Kamili *</label>
                                        <input type="text" name="name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Simu *</label>
                                        <input type="text" name="phone" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Jinsia *</label>
                                        <select name="gender" class="form-select shadow-none" required>
                                            <option value="">--</option>
                                            <option value="male">Mwanaume</option>
                                            <option value="female">Mwanamke</option>
                                            <option value="other">Nyingine</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Damu</label>
                                        <select name="blood_group" class="form-select shadow-none">
                                            <option value="">--</option>
                                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                            <option>{{ $bg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold">Mawasiliano ya Dharura</label>
                                        <input type="text" name="emergency_contact" class="form-control shadow-none">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Allergies / Mzio</label>
                                        <textarea name="allergies" rows="2" class="form-control shadow-none"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success fw-semibold mt-3 w-100">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Sajili & Endelea
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Send to doctor --}}
                <div id="stepSend" style="display:none">
                    <div class="alert alert-success border-0 d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <div class="fw-bold small">Patient Selected:</div>
                            <div id="selectedPatientName" class="small"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light ms-auto" id="changePatientBtn">Change</button>
                    </div>

                    <input type="hidden" id="selPatientId">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Doctor *</label>
                            <select id="sendDoctor" class="form-select shadow-none" required>
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $d)
                                <option value="{{ $d->id }}">Dr. {{ $d->display_name }} — {{ $d->specialization ?? 'General' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Service Type</label>
                            <select id="sendType" class="form-select shadow-none">
                                <option>General Consultation</option>
                                <option>Follow-up</option>
                                <option>Maternal Care</option>
                                <option>Vaccination</option>
                                <option>Emergency</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Reason for Visit (Chief Complaint)</label>
                            <textarea id="sendComplaint" rows="3" class="form-control shadow-none" placeholder="Example: Stomach pain for 3 days..."></textarea>
                        </div>
                    </div>
                    <button type="button" id="sendToDoctorBtn" class="btn btn-primary fw-semibold mt-3 w-100">
                        <i class="fa-solid fa-paper-plane me-2"></i>Send to Doctor
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    const CSRF = '{{ csrf_token() }}';
    let searchTimer = null;

    // ─── Step 1a: Search existing patient ───────────────────
    $('#patientSearch').on('input', function () {
        const q = $(this).val().trim();
        clearTimeout(searchTimer);
        if (q.length < 2) { $('#searchResults').empty(); return; }

        searchTimer = setTimeout(() => {
            $.get('{{ route("receptionist.visits.search") }}', { q })
                .done(resp => {
                    const list = resp.data || [];
                    if (!list.length) {
                        $('#searchResults').html('<div class="text-center py-3 text-muted small"><i class="fa-solid fa-circle-question me-1"></i>No results. Register as new.</div>');
                        return;
                    }
                    let html = '';
                    list.forEach(p => {
                        html += `
                        <div class="d-flex align-items-center gap-2 p-2 rounded-2 border mb-1 patient-row" style="cursor:pointer"
                            data-id="${p.id}" data-name="${p.name}" data-num="${p.patient_number}">
                            <div class="user-avatar bg-blue-soft text-blue">${(p.name||'?')[0].toUpperCase()}</div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">${p.name}</div>
                                <div class="text-muted" style="font-size:.7rem">${p.patient_number} · ${p.phone||''}</div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </div>`;
                    });
                    $('#searchResults').html(html);
                });
        }, 300);
    });

    $(document).on('click', '.patient-row', function () {
        $('#selPatientId').val($(this).data('id'));
        $('#selectedPatientName').text(`${$(this).data('num')} — ${$(this).data('name')}`);
        $('#stepFind').hide();
        $('#stepSend').show();
    });

    $('#changePatientBtn').on('click', () => {
        $('#stepSend').hide();
        $('#stepFind').show();
        $('#selPatientId').val('');
    });

    // ─── Step 1b: Register new patient ──────────────────────
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button[type=submit]').prop('disabled', true);
        $.ajax({
            url: '{{ route("receptionist.visits.register") }}',
            method: 'POST',
            data: $(this).serialize() + '&_token=' + CSRF,
        }).done(r => {
            if (r.success) {
                $('#selPatientId').val(r.patient.id);
                $('#selectedPatientName').text(`${r.patient.patient_number} — ${r.patient.name}`);
                $('#stepFind').hide();
                $('#stepSend').show();
                Swal.fire({icon:'success',title:r.message,timer:1400,showConfirmButton:false});
                $('#registerForm')[0].reset();
            } else {
                Swal.fire('Error', r.message || 'Failed', 'error');
            }
        }).fail(xhr => {
            const msg = xhr.responseJSON?.message ?? Object.values(xhr.responseJSON?.errors ?? {}).flat().join('\n') ?? 'Imeshindwa';
            Swal.fire('Error', msg, 'error');
        }).always(() => $btn.prop('disabled', false));
    });

    // ─── Step 2: Send to doctor ─────────────────────────────
    $('#sendToDoctorBtn').on('click', function () {
        const patient_id = $('#selPatientId').val();
        const doctor_id  = $('#sendDoctor').val();
        if (!patient_id || !doctor_id) {
            return Swal.fire('Warning', 'Please select patient and doctor', 'warning');
        }
        const $btn = $(this).prop('disabled', true);
        $.post('{{ route("receptionist.visits.send") }}', {
            _token: CSRF,
            patient_id, doctor_id,
            type: $('#sendType').val(),
            chief_complaint: $('#sendComplaint').val(),
        }).done(r => {
            if (r.success) {
                Swal.fire({icon:'success',title:r.message,timer:1600,showConfirmButton:false})
                    .then(() => location.reload());
            } else {
                Swal.fire('Hitilafu', r.message, 'error');
            }
        }).fail(xhr => {
            Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
        }).always(() => $btn.prop('disabled', false));
    });

    // ─── Cancel visit ──────────────────────────────────────
    $(document).on('click', '.cancel-visit', function () {
        const id = $(this).data('id');
        Swal.fire({
            title:'Cancel appointment?', icon:'warning', showCancelButton:true,
            confirmButtonText:'Yes, Cancel', cancelButtonText:'No',
            confirmButtonColor:'#ef4444'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.post(`{{ url('receptionist/visits') }}/${id}/cancel`, { _token: CSRF })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                            .then(() => location.reload());
                    }
                });
        });
    });

    // ─── Filter ────────────────────────────────────────────
    function applyFilter() {
        const q = $('#qSearch').val().toLowerCase();
        const s = $('#qStage').val();
        const d = $('#qDoctor').val();
        $('#queueTable tbody tr').each(function () {
            const txt = $(this).text().toLowerCase();
            const stg = $(this).data('stage') ?? '';
            const doc = $(this).data('doctor') ?? '';
            let show = true;
            if (q && !txt.includes(q)) show = false;
            if (s && stg !== s) show = false;
            if (d && doc !== d) show = false;
            $(this).toggle(show);
        });
    }
    $('#qSearch, #qStage, #qDoctor').on('input change', applyFilter);
});
</script>
@endpush
@endsection
