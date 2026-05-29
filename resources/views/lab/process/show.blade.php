@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <div class="d-flex align-items-center gap-3 mb-2">
                <a href="{{ route('lab.process.index') }}" class="btn btn-light rounded-2 btn-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0">Lab Test Request</h4>
                    <p class="text-muted small mb-0">{{ $labRequest->test_names }}</p>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <span class="status-badge {{ $labRequest->status_badge }} px-3 py-2">{{ ucfirst($labRequest->status) }}</span>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left: Patient & Request Info --}}
        <div class="col-lg-4">
            {{-- Patient Card --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-user me-2"></i>Patient</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="user-avatar bg-blue-soft text-blue" style="width:64px;height:64px;font-size:1.5rem">
                            {{ strtoupper(substr($labRequest->patient->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ $labRequest->patient->name ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ $labRequest->patientProfile->patient_number ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Request Details --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-flask me-2 text-amber"></i>Request Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">Doctor:</span>
                        <div class="fw-semibold small">Dr. {{ $labRequest->doctor->name ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Priority:</span>
                        <div><span class="status-badge {{ $labRequest->priority_badge }}">{{ ucfirst($labRequest->priority) }}</span></div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Tests:</span>
                        <div class="small">{{ $labRequest->test_names }}</div>
                    </div>
                    <div>
                        <span class="text-muted small">Clinical Notes:</span>
                        <div class="small">{{ $labRequest->clinical_notes ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Results Entry --}}
        <div class="col-lg-8">
            {{-- Start Button (if pending) --}}
            @if($labRequest->status === \App\Models\LabRequest::STATUS_PENDING)
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-body text-center py-4">
                    <button class="btn btn-warning fw-semibold px-4" id="startBtn">
                        <i class="fa-solid fa-play me-2"></i>Start Processing
                    </button>
                </div>
            </div>
            @endif

            {{-- Results Form --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-clipboard-list me-2 text-blue"></i>Enter Results</h6>
                </div>
                <div class="card-body">
                    <form id="resultsForm">
                        <div id="resultRows">
                            @php
                                $tests = $labRequest->test_list;
                                $savedResults = $labRequest->result_data ?? [];
                            @endphp
                            @foreach($tests as $idx => $testName)
                            @php
                                $saved = collect($savedResults)->firstWhere('test_name', $testName) ?? [];
                            @endphp
                            <div class="row g-2 mb-3 result-row">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Test Name</label>
                                    <input type="text" name="results[{{ $idx }}][test_name]" class="form-control form-control-sm shadow-none"
                                        value="{{ $testName }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Value</label>
                                    <input type="text" name="results[{{ $idx }}][value]" class="form-control form-control-sm shadow-none"
                                        value="{{ $saved['value'] ?? '' }}" placeholder="—">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Unit</label>
                                    <input type="text" name="results[{{ $idx }}][unit]" class="form-control form-control-sm shadow-none"
                                        value="{{ $saved['unit'] ?? '' }}" placeholder="mg/dL">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Normal Range</label>
                                    <input type="text" name="results[{{ $idx }}][normal_range]" class="form-control form-control-sm shadow-none"
                                        value="{{ $saved['normal_range'] ?? '' }}" placeholder="—">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Flag</label>
                                    <select name="results[{{ $idx }}][flag]" class="form-select form-select-sm shadow-none">
                                        <option value="">--</option>
                                        <option value="normal" {{ ($saved['flag'] ?? '') === 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="low" {{ ($saved['flag'] ?? '') === 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="high" {{ ($saved['flag'] ?? '') === 'high' ? 'selected' : '' }}>High</option>
                                        <option value="critical" {{ ($saved['flag'] ?? '') === 'critical' ? 'selected' : '' }}>Critical</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Result Notes</label>
                            <textarea name="result_notes" rows="3" class="form-control shadow-none">{{ $labRequest->result_notes ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Upload Result Images/Documents</label>
                            <input type="file" name="result_files[]" class="form-control shadow-none" multiple accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">Upload result images or PDF (Max 5MB per file)</small>
                        </div>
                        <button type="submit" class="btn btn-success fw-semibold w-100">
                            <i class="fa-solid fa-check me-2"></i>Save Results & Complete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cancel Button --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-body">
                    <button class="btn btn-outline-danger w-100" id="cancelBtn">
                        <i class="fa-solid fa-xmark me-2"></i>Cancel This Request
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
    const reqId = {{ $labRequest->id }};

    // ─── Start Processing ─────────────────────────────────────
    $('#startBtn').on('click', function () {
        const $btn = $(this).prop('disabled', true);
        $.post(`{{ url('lab/process') }}/${reqId}/start`, { _token: CSRF })
            .done(r => {
                if (r.success) {
                    Swal.fire({icon:'success',title:r.message,timer:1400,showConfirmButton:false})
                        .then(() => location.reload());
                }
            })
            .fail(() => Swal.fire('Hitilafu', 'Imeshindika', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Save Results & Complete ─────────────────────────────
    $('#resultsForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button[type=submit]').prop('disabled', true);
        $.post(`{{ url('lab/process') }}/${reqId}/complete`, $(this).serialize() + '&_token=' + CSRF)
            .done(r => {
                if (r.success) {
                    Swal.fire({icon:'success',title:r.message,timer:1600,showConfirmButton:false})
                        .then(() => location.href = '{{ route('lab.process.index') }}');
                }
            })
            .fail(xhr => Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Cancel Request ───────────────────────────────────────
    $('#cancelBtn').on('click', function () {
        Swal.fire({
            title:'Cancel Request?', text:'Patient will return to doctor.', icon:'warning',
            showCancelButton:true, confirmButtonText:'Yes, Cancel', cancelButtonText:'No',
            confirmButtonColor:'#ef4444'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.post(`{{ url('lab/process') }}/${reqId}/cancel`, { _token: CSRF })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                            .then(() => location.href = '{{ route('lab.process.index') }}');
                    }
                })
                .fail(() => Swal.fire('Error', 'Failed', 'error'));
        });
    });
});
</script>
@endpush
@endsection
