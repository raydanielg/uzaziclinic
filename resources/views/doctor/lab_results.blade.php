@extends('layouts.app')

@section('content')
<div class="doctor-lab-results py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Completed Lab Results</h4>
                <p class="text-muted small">View and review detailed laboratory reports for your patients</p>
            </div>
            <a href="{{ route('doctor.lab.requests') }}" class="btn btn-light rounded-1 px-4 border-0 text-primary fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Requests
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="resultsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Completion Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Test Names</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Technician Note</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completed_results ?? [] as $result)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $result->updated_at->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ $result->updated_at->format('H:i A') }}</div>
                            </td>
                            <td class="fw-bold text-dark">{{ $result->patient->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-1">{{ $result->test_names }}</span></td>
                            <td><p class="small mb-0 text-truncate" style="max-width: 200px;">{{ $result->result_notes ?? 'No technician notes available.' }}</p></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-primary rounded-1 px-3 fw-bold">
                                    <i class="fa-solid fa-file-pdf me-1"></i> View Report
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-file-circle-xmark fs-1 opacity-25 mb-3 d-block"></i>
                                No completed lab results found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#resultsTable').DataTable({
        pageLength: 10,
        language: { search: "", searchPlaceholder: "Search results..." }
    });
});
</script>
@endpush
@endsection
