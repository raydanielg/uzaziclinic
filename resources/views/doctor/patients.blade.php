@extends('layouts.app')

@section('content')
<div class="doctor-patients py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">My Patients</h4>
                <p class="text-muted small">Manage and view history of all your assigned patients</p>
            </div>
            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0">
                <i class="fa-solid fa-user-plus me-2"></i> New Patient
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="patientsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient ID</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Last Visit</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- This would be populated from database -->
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="fw-bold">Jane Cooper</div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border rounded-1">PT-8829</span></td>
                            <td>May 10, 2026</td>
                            <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Stable</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1"><i class="fa-solid fa-eye me-1"></i> Details</button>
                            </td>
                        </tr>
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
        language: { search: "", searchPlaceholder: "Search patients..." }
    });
});
</script>
@endpush
@endsection
