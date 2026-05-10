@extends('layouts.app')

@section('content')
<div class="nurse-patients py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Patient Management</h4>
                <p class="text-muted small">Comprehensive list of all registered clinic patients.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="managePatientsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Contact</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Gender</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fa-solid fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                        <div class="small text-muted">Joined: {{ $patient->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small fw-bold text-dark">{{ $patient->phone ?? $patient->email }}</td>
                            <td class="small">{{ ucfirst($patient->gender ?? 'Not Specified') }}</td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Active</span></td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-1 border-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></button>
                                    <ul class="dropdown-menu border-0 shadow-sm">
                                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-eye me-2"></i> View Profile</a></li>
                                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-history me-2"></i> Medical History</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#managePatientsTable').DataTable({
        paging: false,
        language: { search: "", searchPlaceholder: "Search patient database..." }
    });
});
</script>
@endpush
@endsection
