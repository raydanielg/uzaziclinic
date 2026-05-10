@extends('layouts.app')

@section('content')
<div class="doctor-medical-records py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Medical Records</h4>
                <p class="text-muted small">Manage and review digital health records of your patients</p>
            </div>
            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0 fw-bold" data-bs-toggle="modal" data-bs-target="#newRecordModal">
                <i class="fa-solid fa-file-medical me-2"></i> New Record
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="recordsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Diagnosis</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medical_records ?? [] as $record)
                        <tr>
                            <td class="ps-4">{{ $record->created_at->format('M d, Y') }}</td>
                            <td class="fw-bold text-dark">{{ $record->patient->name ?? 'N/A' }}</td>
                            <td>{{ $record->diagnosis }}</td>
                            <td>{{ $record->doctor->name ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1 text-primary border-0"><i class="fa-solid fa-eye me-1"></i> View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-1 opacity-25 mb-3 d-block"></i>
                                No medical records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Simple New Record Modal -->
<div class="modal fade" id="newRecordModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-file-medical me-2"></i>Create Medical Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
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
                            <label class="form-label small fw-bold text-muted text-uppercase">Diagnosis</label>
                            <input type="text" name="diagnosis" class="form-control rounded-1 border-light bg-light shadow-none" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Clinical Notes</label>
                            <textarea name="notes" class="form-control rounded-1 border-light bg-light shadow-none" rows="5" placeholder="Detailed medical history, symptoms, observations..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-1 px-4 border-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0 fw-bold">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#recordsTable').DataTable({
        pageLength: 10,
        language: { search: "", searchPlaceholder: "Search records..." }
    });
});
</script>
@endpush
@endsection
