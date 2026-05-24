@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <div class="d-flex align-items-center gap-3 mb-2">
                <a href="{{ route('doctor.consultation.queue') }}" class="btn btn-light rounded-2 btn-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0">Chumba cha Ushauri</h4>
                    <p class="text-muted small mb-0">{{ $appointment->queue_number ?? 'Q??' }} · {{ $appointment->patient->display_name }}</p>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <span class="status-badge {{ $appointment->stage_badge }} px-3 py-2">{{ $appointment->stage_label }}</span>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left: Patient Info & Vitals --}}
        <div class="col-lg-4">
            {{-- Patient Card --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-user me-2"></i>Maelezo ya Mgonjwa</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="user-avatar bg-blue-soft text-blue" style="width:64px;height:64px;font-size:1.5rem">
                            {{ strtoupper(substr($appointment->patient->display_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ $appointment->patient->display_name }}</div>
                            <div class="text-muted small">{{ $appointment->patient->patient_number }}</div>
                            <div class="text-muted small">{{ $appointment->patient->phone ?? '' }}</div>
                        </div>
                    </div>
                    <div class="row g-2 small">
                        <div class="col-6"><span class="text-muted">Jinsia:</span> {{ ucfirst($appointment->patient->gender ?? '') }}</div>
                        <div class="col-6"><span class="text-muted">Damu:</span> {{ $appointment->patient->blood_group ?? '—' }}</div>
                        <div class="col-12"><span class="text-muted">Mzio:</span> {{ $appointment->patient->allergies ?? 'Hakuna' }}</div>
                    </div>
                </div>
            </div>

            {{-- Vitals --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-heart-pulse me-2 text-rose"></i>Vitals</h6>
                </div>
                <div class="card-body">
                    <form id="vitalsForm">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">BP (mmHg)</label>
                                <input type="text" name="vital_signs[bp]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['bp'] ?? '' }}" placeholder="120/80">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Pulse (bpm)</label>
                                <input type="text" name="vital_signs[pulse]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['pulse'] ?? '' }}" placeholder="72">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Temp (°C)</label>
                                <input type="text" name="vital_signs[temp]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['temp'] ?? '' }}" placeholder="37.0">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">SpO2 (%)</label>
                                <input type="text" name="vital_signs[spo2]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['spo2'] ?? '' }}" placeholder="98">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Weight (kg)</label>
                                <input type="text" name="vital_signs[weight]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['weight'] ?? '' }}" placeholder="70">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Height (cm)</label>
                                <input type="text" name="vital_signs[height]" class="form-control form-control-sm shadow-none"
                                    value="{{ $appointment->vital_signs['height'] ?? '' }}" placeholder="170">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success w-100 fw-semibold">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Hifadhi Vitals
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: Complaint, Symptoms, Lab, Prescription --}}
        <div class="col-lg-8">
            {{-- Complaint & Symptoms --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-file-medical me-2 text-blue"></i>Sababu ya Kuja & Dalili</h6>
                </div>
                <div class="card-body">
                    <form id="complaintForm">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Sababu Kuu (Chief Complaint)</label>
                            <textarea name="chief_complaint" rows="2" class="form-control shadow-none"
                                placeholder="Mfano: Maumivu ya tumbo kwa siku 3...">{{ $appointment->chief_complaint ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Dalili (Symptoms)</label>
                            <textarea name="symptoms" rows="3" class="form-control shadow-none"
                                placeholder="Andika dalili zote...">{{ $appointment->symptoms ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary fw-semibold">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Hifadhi
                        </button>
                    </form>
                </div>
            </div>

            {{-- Lab Requests --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-flask me-2 text-amber"></i>Majaribio ya Lab</h6>
                    <button class="btn btn-sm btn-light rounded-2" data-bs-toggle="modal" data-bs-target="#labModal">
                        <i class="fa-solid fa-plus me-1"></i>Omba Lab
                    </button>
                </div>
                <div class="card-body">
                    @forelse($appointment->labRequests as $lr)
                    <div class="d-flex align-items-center gap-2 p-2 rounded-2 border mb-2">
                        <div class="user-avatar bg-amber-soft text-amber"><i class="fa-solid fa-flask"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">{{ $lr->test_names }}</div>
                            <div class="text-muted" style="font-size:.7rem">{{ $lr->priority }} · {{ $lr->status }}</div>
                        </div>
                        <span class="status-badge {{ $lr->status_badge }} px-2 py-1">{{ ucfirst($lr->status) }}</span>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted small">Hakuna ombi la lab kwa miadi hii</div>
                    @endforelse
                </div>
            </div>

            {{-- Prescriptions --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-pills me-2 text-violet"></i>Dawa (Prescription)</h6>
                    <button class="btn btn-sm btn-light rounded-2" data-bs-toggle="modal" data-bs-target="#prescribeModal">
                        <i class="fa-solid fa-plus me-1"></i>Andika Dawa
                    </button>
                </div>
                <div class="card-body">
                    @forelse($appointment->prescriptions as $rx)
                    <div class="d-flex align-items-center gap-2 p-2 rounded-2 border mb-2">
                        <div class="user-avatar bg-violet-soft text-violet"><i class="fa-solid fa-pills"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">{{ $rx->diagnosis ?? '—' }}</div>
                            <div class="text-muted" style="font-size:.7rem">{{ $rx->items->count() }} item(s) · {{ $rx->status }}</div>
                        </div>
                        <span class="status-badge {{ $rx->status_badge }} px-2 py-1">{{ ucfirst($rx->status) }}</span>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted small">Hakuna prescription kwa miadi hii</div>
                    @endforelse
                </div>
            </div>

            {{-- Actions --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-body d-flex gap-2">
                    <button class="btn btn-success fw-semibold flex-grow-1" id="completeBtn">
                        <i class="fa-solid fa-circle-check me-2"></i>Maliza Ushauri (Bila Dawa)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────────────────────
     Lab Request Modal
     ───────────────────────────────────────────────────────── --}}
<div class="modal fade" id="labModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-amber text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-flask me-2"></i>Omba Majaribio ya Lab</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="labForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Majaribio (Chagua zaidi ya moja)</label>
                        <select name="test_names[]" class="form-select shadow-none" multiple size="6">
                            @foreach($availableTests as $t)
                            <option value="{{ $t->test_name }}">{{ $t->test_name }} ({{ $t->test_type }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Bonyza Ctrl+Click kuchagua zaidi ya moja</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kipaumbele</label>
                        <select name="priority" class="form-select shadow-none">
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Maelezo ya Kliniki</label>
                        <textarea name="clinical_notes" rows="3" class="form-control shadow-none"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning fw-semibold w-100">
                        <i class="fa-solid fa-paper-plane me-2"></i>Tuma Ombi la Lab
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────────────────────
     Prescription Modal
     ───────────────────────────────────────────────────────── --}}
<div class="modal fade" id="prescribeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-violet text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-pills me-2"></i>Andika Dawa</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="prescribeForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Utambuzi (Diagnosis) *</label>
                        <textarea name="diagnosis" rows="2" class="form-control shadow-none" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Maelezo</label>
                        <textarea name="notes" rows="2" class="form-control shadow-none"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Dawa</label>
                        <div id="medicineRows">
                            <div class="row g-2 mb-2 medicine-row">
                                <div class="col-md-4">
                                    <select name="items[0][medicine_id]" class="form-select form-select-sm medicine-select shadow-none">
                                        <option value="">-- Chagua Dawa --</option>
                                        @foreach($medicines as $m)
                                        <option value="{{ $m->id }}" data-name="{{ $m->name }}" data-price="{{ $m->price }}">{{ $m->name }} ({{ $m->quantity }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="items[0][quantity]" class="form-control form-control-sm shadow-none" placeholder="Qty" min="1" value="1">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="items[0][dosage]" class="form-control form-control-sm shadow-none" placeholder="Dose">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="items[0][frequency]" class="form-control form-control-sm shadow-none" placeholder="Freq">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-light remove-row"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light mt-2" id="addMedicineRow">
                            <i class="fa-solid fa-plus me-1"></i>Ongeza Dawa Nyingine
                        </button>
                    </div>
                    <button type="submit" class="btn btn-violet fw-semibold w-100" style="background:#8b5cf6;color:#fff">
                        <i class="fa-solid fa-paper-plane me-2"></i>Tuma Prescription
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    const CSRF = '{{ csrf_token() }}';
    const apptId = {{ $appointment->id }};

    // ─── Save Vitals ───────────────────────────────────────
    $('#vitalsForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button').prop('disabled', true);
        $.post(`{{ url('doctor/consultation') }}/${apptId}/vitals`, $(this).serialize() + '&_token=' + CSRF)
            .done(r => {
                if (r.success) Swal.fire({icon:'success',title:r.message,timer:1200,showConfirmButton:false});
            })
            .fail(() => Swal.fire('Hitilafu', 'Imeshindwa kuhifadhi vitals', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Save Complaint/Symptoms ────────────────────────────
    $('#complaintForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button').prop('disabled', true);
        $.post(`{{ url('doctor/consultation') }}/${apptId}/vitals`, $(this).serialize() + '&_token=' + CSRF)
            .done(r => {
                if (r.success) Swal.fire({icon:'success',title:'Maelezo yamehifadhiwa',timer:1200,showConfirmButton:false});
            })
            .fail(() => Swal.fire('Hitilafu', 'Imeshindwa', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Lab Request ─────────────────────────────────────────
    $('#labForm').on('submit', function (e) {
        e.preventDefault();
        const data = $(this).serialize() + '&_token=' + CSRF;
        const $btn = $(this).find('button').prop('disabled', true);
        $.post(`{{ url('doctor/consultation') }}/${apptId}/lab`, data)
            .done(r => {
                if (r.success) {
                    Swal.fire({icon:'success',title:r.message,timer:1600,showConfirmButton:false})
                        .then(() => location.reload());
                }
            })
            .fail(xhr => Swal.fire('Hitilafu', xhr.responseJSON?.message ?? 'Imeshindika', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Prescription ───────────────────────────────────────
    let medRowIdx = 1;
    $('#addMedicineRow').on('click', function () {
        const row = `
        <div class="row g-2 mb-2 medicine-row">
            <div class="col-md-4">
                <select name="items[${medRowIdx}][medicine_id]" class="form-select form-select-sm medicine-select shadow-none">
                    <option value="">-- Chagua Dawa --</option>
                    @foreach($medicines as $m)
                    <option value="{{ $m->id }}" data-name="{{ $m->name }}" data-price="{{ $m->price }}">{{ $m->name }} ({{ $m->quantity }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${medRowIdx}][quantity]" class="form-control form-control-sm shadow-none" placeholder="Qty" min="1" value="1">
            </div>
            <div class="col-md-2">
                <input type="text" name="items[${medRowIdx}][dosage]" class="form-control form-control-sm shadow-none" placeholder="Dose">
            </div>
            <div class="col-md-2">
                <input type="text" name="items[${medRowIdx}][frequency]" class="form-control form-control-sm shadow-none" placeholder="Freq">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-light remove-row"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>`;
        $('#medicineRows').append(row);
        medRowIdx++;
    });

    $(document).on('click', '.remove-row', function () {
        $(this).closest('.medicine-row').remove();
    });

    $(document).on('change', '.medicine-select', function () {
        const $opt = $(this).find('option:selected');
        const $row = $(this).closest('.medicine-row');
        if ($opt.val()) {
            $row.find('input[name$="[medicine_name]"]').remove();
            $row.find('select').after(`<input type="hidden" name="${$(this).attr('name').replace('medicine_id','medicine_name')}" value="${$opt.data('name')}">`);
        }
    });

    $('#prescribeForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button').prop('disabled', true);
        $.post(`{{ url('doctor/consultation') }}/${apptId}/prescribe`, $(this).serialize() + '&_token=' + CSRF)
            .done(r => {
                if (r.success) {
                    Swal.fire({icon:'success',title:r.message,timer:1600,showConfirmButton:false})
                        .then(() => location.reload());
                }
            })
            .fail(xhr => Swal.fire('Hitilafu', xhr.responseJSON?.message ?? 'Imeshindika', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Complete (no pharmacy) ───────────────────────────────
    $('#completeBtn').on('click', function () {
        Swal.fire({
            title:'Maliza Ushauri?', text:'Hakuna dawa. Miadi itakamilika.', icon:'info',
            showCancelButton:true, confirmButtonText:'Ndiyo', cancelButtonText:'Hapana'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.post(`{{ url('doctor/consultation') }}/${apptId}/complete`, { _token: CSRF })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                            .then(() => location.href = '{{ route('doctor.consultation.queue') }}');
                    }
                })
                .fail(() => Swal.fire('Hitilafu', 'Imeshindika', 'error'));
        });
    });
});
</script>
@endpush
@endsection
