@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Lab Requests</h1>
                <p class="text-muted small mb-0">View and process all incoming laboratory test requests.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-flask me-2 text-primary"></i>All Lab Requests</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" style="width:auto;">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="requestsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">#Ref</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Patient</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Requested By</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Tests</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Priority</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Date</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#LAB-{{ $req->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $req->patient->name ?? 'N/A' }}</div>
                                    <small class="text-muted">ID: #PT-{{ $req->patient_id }}</small>
                                </td>
                                <td>Dr. {{ $req->doctor->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="small">{{ Str::limit($req->test_names, 40) }}</span>
                                </td>
                                <td>
                                    @php
                                        $pClass = match($req->priority ?? 'normal') {
                                            'urgent' => 'danger', 'high' => 'warning', default => 'info'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $pClass }}-subtle text-{{ $pClass }} rounded-pill">{{ ucfirst($req->priority ?? 'normal') }}</span>
                                </td>
                                <td class="small text-muted">{{ $req->created_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $sClass = match($req->status) {
                                            'completed' => 'success', 'processing' => 'primary', default => 'warning'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $sClass }}-subtle text-{{ $sClass }} rounded-pill">{{ ucfirst($req->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary rounded-2">Process</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-flask fs-2 d-block mb-2 opacity-25"></i>
                                    No lab requests found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($requests->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#requestsTable').DataTable({
        paging: false,
        info: false,
        order: [[5,'desc']],
    });
});
</script>
@endpush
@endsection
