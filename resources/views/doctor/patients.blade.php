@extends('layouts.app')

@section('content')
<div class="doctor-patients py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">My Patients</h4>
                <p class="text-muted small">Manage and view history of all your assigned patients</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="patientsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Email / Phone</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Join Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                        <div class="small text-muted">ID: #PT-{{ $patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-bold text-dark">{{ $patient->email }}</div>
                                <div class="small text-muted">{{ $patient->phone ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $patient->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ ucfirst($patient->status ?? 'Active') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('doctor.patients.details', $patient->id) }}" class="btn btn-sm btn-light rounded-1 px-3 fw-bold text-primary">
                                    <i class="fa-solid fa-eye me-1"></i> View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#patientsTable').DataTable({
        pageLength: 10,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search patients...",
            lengthMenu: "_MENU_ entries per page"
        }
    });
});
</script>
@endpush
@endsection
