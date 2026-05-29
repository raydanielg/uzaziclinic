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
                    <tr data-stage="{{ $v->current_stage }}" data-id="{{ $v->id }}" data-doctor="{{ $v->doctor_id ?? '' }}">
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
                            <div class="btn-group">
                                @if(!in_array($v->status, ['cancelled','completed']))
                                <button class="btn btn-sm btn-light rounded-2" onclick="changeDoctor({{ $v->id }}, {{ $v->doctor_id ?? 'null' }})" title="Change Doctor">
                                    <i class="fa-solid fa-user-doctor text-blue"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-2" onclick="openPayment({{ $v->id }}, '{{ $v->patient->display_name ?? 'N/A' }}', '{{ $v->patient->patient_number ?? 'N/A' }}')" title="Payment & Discharge">
                                    <i class="fa-solid fa-credit-card text-green"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-2 cancel-visit" data-id="{{ $v->id }}" title="Cancel">
                                    <i class="fa-solid fa-xmark text-rose"></i>
                                </button>
                                @else
                                <span class="badge bg-success">Completed</span>
                                @endif
                            </div>
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

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-success text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-credit-card me-2"></i>Payment & Discharge</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="paymentVisitId">
                
                <!-- Patient Info -->
                <div class="alert alert-info border-0 d-flex align-items-center gap-3 mb-4">
                    <div class="user-avatar bg-white text-success" style="width:50px;height:50px;font-size:1.2rem">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold" id="paymentPatientName">Patient Name</div>
                        <div class="small text-muted" id="paymentPatientNumber">PT-001</div>
                    </div>
                </div>

                <!-- Services Received -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-list-check me-2"></i>Services Received</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th class="text-end">Cost</th>
                                </tr>
                            </thead>
                            <tbody id="servicesList">
                                <tr>
                                    <td>Doctor Consultation</td>
                                    <td class="text-end">TZS 5,000</td>
                                </tr>
                                <tr>
                                    <td>Laboratory Tests</td>
                                    <td class="text-end">TZS 15,000</td>
                                </tr>
                                <tr>
                                    <td>Medication</td>
                                    <td class="text-end">TZS 25,000</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-success">
                                    <th class="fw-bold">Total</th>
                                    <th class="text-end fw-bold" id="totalCost">TZS 45,000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-wallet me-2"></i>Payment Method</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-check-label small fw-bold mb-2 d-block">Select Method</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="paymentMethod" id="payCash" value="cash" checked>
                                <label class="btn btn-outline-success" for="payCash">
                                    <i class="fa-solid fa-money-bill-wave me-1"></i>Cash
                                </label>
                                
                                <input type="radio" class="btn-check" name="paymentMethod" id="payBank" value="bank">
                                <label class="btn btn-outline-success" for="payBank">
                                    <i class="fa-solid fa-building-columns me-1"></i>Bank
                                </label>
                                
                                <input type="radio" class="btn-check" name="paymentMethod" id="payMobile" value="mobile">
                                <label class="btn btn-outline-success" for="payMobile">
                                    <i class="fa-solid fa-mobile-screen me-1"></i>Mobile
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold">Payment Details</label>
                            <input type="text" id="paymentDetails" class="form-control" placeholder="Enter payment reference or notes...">
                        </div>
                    </div>
                </div>

                <!-- Amount Received -->
                <div class="mb-4">
                    <label class="form-label small fw-bold">Amount Received</label>
                    <div class="input-group">
                        <span class="input-group-text">TZS</span>
                        <input type="number" id="amountReceived" class="form-control" placeholder="Enter amount">
                    </div>
                    <div id="changeAmount" class="mt-2 text-success fw-bold" style="display:none">
                        Change: TZS <span id="changeValue">0</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded-1 px-4" id="processPaymentBtn">
                    <i class="fa-solid fa-check-circle me-2"></i>Process Payment & Discharge
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Doctor Modal -->
<div class="modal fade" id="changeDoctorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-doctor me-2"></i>Change Doctor</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="changeVisitId">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select New Doctor</label>
                    <select id="newDoctorSelect" class="form-select" required>
                        <option value="">Loading doctors...</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Reason for Change (Optional)</label>
                    <textarea id="changeReason" rows="3" class="form-control" placeholder="Explain why changing doctor..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4" id="confirmChangeDoctorBtn"><i class="fa-solid fa-exchange-alt me-2"></i>Change Doctor</button>
            </div>
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
                                        <label class="form-label small fw-bold">Full Name *</label>
                                        <input type="text" name="name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Phone *</label>
                                        <input type="text" name="phone" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Gender *</label>
                                        <select name="gender" class="form-select shadow-none" required>
                                            <option value="">--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Blood Type</label>
                                        <select name="blood_group" class="form-select shadow-none">
                                            <option value="">--</option>
                                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                            <option>{{ $bg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold">Emergency Contact</label>
                                        <input type="text" name="emergency_contact" class="form-control shadow-none">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Allergies</label>
                                        <textarea name="allergies" rows="2" class="form-control shadow-none"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success fw-semibold mt-3 w-100">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Register & Continue
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

    // ─── Change Doctor ─────────────────────────────────────
    window.changeDoctor = function(visitId, currentDoctorId) {
        $('#changeVisitId').val(visitId);
        const modal = new bootstrap.Modal(document.getElementById('changeDoctorModal'));
        const doctorSelect = $('#newDoctorSelect');
        
        doctorSelect.html('<option value="">Loading doctors...</option>');
        modal.show();
        
        // Load doctors
        $.get('{{ route("receptionist.doctors") }}')
            .done(function(data) {
                if (data.success && data.doctors) {
                    doctorSelect.html('<option value="">Select a doctor</option>' +
                        data.doctors.map(function(d) {
                            const selected = d.id === currentDoctorId ? 'selected' : '';
                            return `<option value="${d.id}" ${selected}>Dr. ${d.name}</option>`;
                        }).join(''));
                } else {
                    doctorSelect.html('<option value="">No doctors available</option>');
                }
            })
            .fail(function() {
                doctorSelect.html('<option value="">Failed to load doctors</option>');
            });
    };

    $('#confirmChangeDoctorBtn').on('click', function() {
        const visitId = $('#changeVisitId').val();
        const newDoctorId = $('#newDoctorSelect').val();
        const reason = $('#changeReason').val();
        
        if (!newDoctorId) {
            return Swal.fire('Warning', 'Please select a doctor', 'warning');
        }
        
        const $btn = $(this).prop('disabled', true);
        $.post('{{ route("receptionist.visits.change-doctor") }}', {
            _token: CSRF,
            visit_id: visitId,
            doctor_id: newDoctorId,
            reason: reason
        }).done(function(r) {
            if (r.success) {
                Swal.fire({icon:'success',title:r.message,timer:1500,showConfirmButton:false})
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', r.message, 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
        }).always(function() {
            $btn.prop('disabled', false);
        });
    });

    // ─── Mark Completed ─────────────────────────────────────
    window.markCompleted = function(visitId) {
        Swal.fire({
            title:'Mark as completed?',
            text:'This will mark the patient visit as completed',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Yes, Complete',
            cancelButtonText:'No',
            confirmButtonColor:'#22c55e'
        }).then(function(r) {
            if (!r.isConfirmed) return;
            
            $.post('{{ route("receptionist.visits.complete") }}', {
                _token: CSRF,
                visit_id: visitId
            }).done(function(resp) {
                if (resp.success) {
                    Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                        .then(() => location.reload());
                }
            }).fail(function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
            });
        });
    };
});
</script>
@endpush
@endsection
