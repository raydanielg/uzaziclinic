@extends('layouts.admin')

@section('page_title', 'Lab Management')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Laboratory Services</h5>
                <a href="#" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-flask-vial me-2"></i> New Test Request
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Test ID</th>
                            <th>Patient</th>
                            <th>Test Type</th>
                            <th>Lab Technician</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold text-primary">#LAB-5021</span></td>
                            <td>David Mwangi</td>
                            <td>Full Blood Picture</td>
                            <td>Sarah Mchapa</td>
                            <td><span class="badge bg-warning-subtle text-warning">Processing</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-file-pdf"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold text-primary">#LAB-5020</span></td>
                            <td>Aisha Bakari</td>
                            <td>Malaria Test</td>
                            <td>Sarah Mchapa</td>
                            <td><span class="badge bg-success-subtle text-success">Completed</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle text-primary"><i class="fa-solid fa-check-double"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
