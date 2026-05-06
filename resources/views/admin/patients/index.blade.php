@extends('layouts.admin')

@section('page_title', 'All Patients')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Patient Registry</h5>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Register Patient
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Age/Gender</th>
                            <th>Last Visit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold text-primary">#PT-001</span></td>
                            <td>Sarah Johnson</td>
                            <td>28 / Female</td>
                            <td>May 05, 2026</td>
                            <td><span class="badge bg-success-subtle text-success">Stable</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
