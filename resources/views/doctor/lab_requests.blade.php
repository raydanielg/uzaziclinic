@extends('layouts.app')

@section('content')
<div class="doctor-lab py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Lab Requests & Results</h4>
                <p class="text-muted small">Track your lab test orders and review patient results</p>
            </div>
            <button class="btn btn-warning rounded-1 px-4 shadow-sm border-0 fw-bold" data-bs-toggle="modal" data-bs-target="#newLabRequestModal">
                <i class="fa-solid fa-flask me-2"></i> New Lab Request
            </button>
        </div>

        <div class="row g-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <ul class="nav nav-pills mb-4 bg-light p-1 rounded-1" id="pills-tab" role="tablist">
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link active rounded-1 small fw-bold text-uppercase py-2" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button" role="tab">Pending Requests ({{ $pending_requests->count() }})</button>
                        </li>
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link rounded-1 small fw-bold text-uppercase py-2" id="pills-results-tab" data-bs-toggle="pill" data-bs-target="#pills-results" type="button" role="tab">Completed Results ({{ $completed_results->count() }})</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Pending Tab -->
                        <div class="tab-pane fade show active" id="pills-pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0" id="pendingTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Tests</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Priority</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pending_requests as $request)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $request->created_at->format('M d, Y') }}</div>
                                                <div class="small text-muted">{{ $request->created_at->format('H:i A') }}</div>
                                            </td>
                                            <td class="fw-bold text-dark">{{ $request->patient->name ?? 'N/A' }}</td>
                                            <td><span class="small">{{ $request->test_names }}</span></td>
                                            <td>
                                                <span class="badge {{ $request->priority == 'urgent' ? 'bg-danger-subtle text-danger' : 'bg-info-subtle text-info' }} rounded-pill px-3">
                                                    {{ ucfirst($request->priority) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">{{ ucfirst($request->status) }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-light rounded-1 text-danger border-0"><i class="fa-solid fa-xmark"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Results Tab -->
                        <div class="tab-pane fade" id="pills-results" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0" id="completedTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Tests</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completed_results as $request)
                                        <tr>
                                            <td class="ps-4">{{ $request->updated_at->format('M d, Y') }}</td>
                                            <td class="fw-bold">{{ $request->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $request->test_names }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary rounded-1 px-3 fw-bold">View Results</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Lab Request Modal -->
<div class="modal fade" id="newLabRequestModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 text-white" style="background: linear-gradient(135deg, #0f4c3a 0%, #166534 50%, #15803d 100%);">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px;">
                        <i class="fa-solid fa-flask fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">New Lab Request</h5>
                        <small class="text-white text-opacity-75">Select patient, choose tests, and submit</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="labRequestForm">
                @csrf
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Patient Selection & Details -->
                        <div class="col-md-4 bg-light p-4 border-end">
                            <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">
                                <i class="fa-solid fa-user-injured me-1"></i> Patient Selection
                            </h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Select Patient <span class="text-danger">*</span></label>
                                <select name="patient_id" id="labPatientSelect" class="form-select border-0 shadow-sm" required style="border-radius: 12px;">
                                    <option value="" data-info="">Choose a patient...</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->user_id }}" data-patient-id="{{ $patient->id }}" data-name="{{ addslashes($patient->name) }}" data-phone="{{ $patient->phone ?? $patient->user->phone ?? '' }}" data-gender="{{ $patient->gender ?? '' }}" data-blood="{{ $patient->blood_group ?? '' }}" data-age="{{ $patient->date_of_birth ? now()->diffInYears($patient->date_of_birth) . ' yrs' : 'N/A' }}">
                                            {{ $patient->name }} (#PT-{{ $patient->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="labPatientCard" class="d-none">
                                <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                                    <div class="card-body p-3 text-center">
                                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981;">
                                            <i class="fa-solid fa-user-injured fs-3" style="color: #059669;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1" id="cardPatientName" style="color: #1e293b;">--</h6>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 small">Active</span>
                                        <div class="text-start mt-3" id="cardPatientDetails">
                                            <!-- Populated by JS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tests & Notes -->
                        <div class="col-md-8 p-4">
                            <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">
                                <i class="fa-solid fa-vials me-1"></i> Lab Tests
                            </h6>
                            <div class="row g-2 mb-4">
                                @forelse($available_tests as $test)
                                <div class="col-md-4">
                                    <div class="form-check p-2 rounded-3 border ps-4" style="border-color: #e2e8f0 !important; background: #f8fafc; transition: all 0.2s; cursor: pointer;" onclick="this.querySelector('input[type=checkbox]').click();">
                                        <input class="form-check-input" type="checkbox" name="test_names[]" value="{{ $test->name }}" id="test_{{ $test->id }}" style="margin-left: -1.2em; margin-top: 0.15em;">
                                        <label class="form-check-label small fw-bold text-dark ms-1" for="test_{{ $test->id }}" style="cursor: pointer;">
                                            {{ $test->name }}
                                        </label>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-light border-0 bg-warning bg-opacity-10 text-warning rounded-3 p-4 text-center">
                                        <i class="fa-solid fa-triangle-exclamation fs-3 d-block mb-2"></i>
                                        <h6 class="fw-bold mb-1">No Lab Tests Available</h6>
                                        <p class="small mb-2">There are no active lab tests configured in the system.</p>
                                        <small class="text-muted">Please contact the administrator to add lab tests to the catalog.</small>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Priority <span class="text-danger">*</span></label>
                                    <select name="priority" class="form-select border-0 bg-light shadow-sm" style="border-radius: 12px;">
                                        <option value="normal">Normal</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="emergency">Emergency</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Clinical Notes</label>
                                    <textarea name="clinical_notes" class="form-control border-0 bg-light shadow-sm" rows="3" placeholder="Describe symptoms, reasons for tests, or any special instructions..." style="border-radius: 12px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-2 fw-semibold" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success rounded-2 px-5 fw-bold shadow-sm" id="submitLabBtn" style="background: linear-gradient(135deg, #059669, #10b981); border: none;">
                        <i class="fa-solid fa-paper-plane me-2"></i>Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable for the visible (active) tab first
    var pendingTable = $('#pendingTable').DataTable({
        pageLength: 5,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Filter records...",
            emptyTable: "No pending requests found."
        }
    });

    // Defer initialization of hidden tab table until it's shown
    var completedTable;
    $('button[data-bs-target="#pills-results"]').on('shown.bs.tab', function () {
        if (!completedTable) {
            completedTable = $('#completedTable').DataTable({
                pageLength: 5,
                responsive: true,
                language: {
                    search: "",
                    searchPlaceholder: "Filter records...",
                    emptyTable: "No completed results found."
                }
            });
        } else {
            completedTable.columns.adjust().responsive.recalc();
        }
    });

    // Patient selection change - show details card
    $('#labPatientSelect').on('change', function() {
        const selected = $(this).find(':selected');
        const card = $('#labPatientCard');
        const details = $('#cardPatientDetails');
        
        if (!$(this).val()) {
            card.addClass('d-none');
            return;
        }
        
        const name = selected.data('name');
        const phone = selected.data('phone') || 'N/A';
        const gender = selected.data('gender') || 'N/A';
        const blood = selected.data('blood') || 'N/A';
        const age = selected.data('age') || 'N/A';
        const genderIcon = gender === 'male' ? 'fa-mars text-primary' : gender === 'female' ? 'fa-venus text-danger' : 'fa-user text-muted';
        const genderLabel = gender ? gender.charAt(0).toUpperCase() + gender.slice(1) : 'N/A';
        
        $('#cardPatientName').text(name);
        
        details.html(`
            <div class="d-flex align-items-center mb-2 p-2 rounded-3" style="background: rgba(59,130,246,0.06);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background: #fff; border: 1px solid rgba(59,130,246,0.15);">
                    <i class="fa-solid fa-phone text-primary small"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.65rem;">Phone</small>
                    <small class="fw-semibold" style="color: #334155;">${phone}</small>
                </div>
            </div>
            <div class="d-flex align-items-center mb-2 p-2 rounded-3" style="background: rgba(236,72,153,0.06);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background: #fff; border: 1px solid rgba(236,72,153,0.15);">
                    <i class="fa-solid ${genderIcon} small"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.65rem;">Gender</small>
                    <small class="fw-semibold" style="color: #334155;">${genderLabel}</small>
                </div>
            </div>
            <div class="d-flex align-items-center mb-2 p-2 rounded-3" style="background: rgba(220,38,38,0.06);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background: #fff; border: 1px solid rgba(220,38,38,0.15);">
                    <i class="fa-solid fa-droplet text-danger small"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.65rem;">Blood Type</small>
                    <small class="fw-semibold" style="color: #334155;">${blood}</small>
                </div>
            </div>
            <div class="d-flex align-items-center p-2 rounded-3" style="background: rgba(245,158,11,0.06);">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background: #fff; border: 1px solid rgba(245,158,11,0.15);">
                    <i class="fa-solid fa-cake-candles text-warning small"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.65rem;">Age</small>
                    <small class="fw-semibold" style="color: #334155;">${age}</small>
                </div>
            </div>
        `);
        
        card.removeClass('d-none');
    });

    $('#labRequestForm').submit(function(e) {
        e.preventDefault();
        
        // Client-side validation
        const patientId = $('#labPatientSelect').val();
        const checkedTests = $('input[name="test_names[]"]:checked').length;
        
        if (!patientId) {
            Swal.fire('Error!', 'Please select a patient first.', 'error');
            $('#labPatientSelect').focus();
            return;
        }
        
        if (checkedTests === 0) {
            Swal.fire('Error!', 'Please select at least one lab test.', 'error');
            return;
        }
        
        const $btn = $('#submitLabBtn');
        const originalText = $btn.html();

        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Submitting...').prop('disabled', true);
        
        $.ajax({
            url: "{{ route('doctor.lab.requests.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                $btn.html(originalText).prop('disabled', false);
                if(resp.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: resp.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                $btn.html(originalText).prop('disabled', false);
                let msg = 'Failed to submit request';
                if (xhr.status === 422 && xhr.responseJSON) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        const errorList = Object.values(errors).flat().join('\n');
                        msg = 'Please fix the following:\n\n' + errorList;
                    } else if (xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Error!', msg, 'error');
            }
        });
    });
});
</script>
@endpush
@endsection
