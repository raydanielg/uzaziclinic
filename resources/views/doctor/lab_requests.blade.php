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
                                        @forelse($pending_requests as $request)
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
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">No pending requests.</td>
                                        </tr>
                                        @endforelse
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
                                        @forelse($completed_results as $request)
                                        <tr>
                                            <td class="ps-4">{{ $request->updated_at->format('M d, Y') }}</td>
                                            <td class="fw-bold">{{ $request->patient->name ?? 'N/A' }}</td>
                                            <td>{{ $request->test_names }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary rounded-1 px-3 fw-bold">View Results</button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">No completed results found.</td>
                                        </tr>
                                        @endforelse
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-flask me-2"></i>New Lab Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="labRequestForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Patient</label>
                            <select name="patient_id" class="form-select rounded-1 border-light bg-light shadow-none" required>
                                <option value="">Choose a patient...</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }} (#PT-{{ $patient->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Tests</label>
                            <div class="row g-2">
                                @foreach($available_tests as $test)
                                <div class="col-md-4">
                                    <div class="form-check p-2 bg-light rounded-1 border border-light ps-5">
                                        <input class="form-check-input" type="checkbox" name="test_names[]" value="{{ $test->name }}" id="test_{{ $test->id }}">
                                        <label class="form-check-label small fw-bold text-dark" for="test_{{ $test->id }}">
                                            {{ $test->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Priority</label>
                            <select name="priority" class="form-select rounded-1 border-light bg-light shadow-none">
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                                <option value="emergency">Emergency</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Clinical Notes</label>
                            <textarea name="clinical_notes" class="form-control rounded-1 border-light bg-light shadow-none" rows="3" placeholder="Symptoms, reasons for test..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-1 px-4 border-0" data-bs-toggle="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0 fw-bold" id="submitLabBtn">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#pendingTable, #completedTable').DataTable({
        pageLength: 5,
        language: { search: "", searchPlaceholder: "Filter records..." }
    });

    $('#labRequestForm').submit(function(e) {
        e.preventDefault();
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
                if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error!', msg, 'error');
            }
        });
    });
});
</script>
@endpush
@endsection
