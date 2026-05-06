@extends('layouts.admin')

@section('page_title', 'All Doctors')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Doctor Directory</h5>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Add Doctor
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Schedule</th>
                            <th>Patients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">DR</div>
                                    <span class="fw-bold">Dr. Robert Smith</span>
                                </div>
                            </td>
                            <td>Cardiologist</td>
                            <td>Mon, Wed, Fri</td>
                            <td>45</td>
                            <td><span class="badge bg-success-subtle text-success">On Duty</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-calendar"></i></button>
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
