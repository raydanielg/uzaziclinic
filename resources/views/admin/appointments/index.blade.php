@extends('layouts.admin')

@section('page_title', 'All Appointments')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Appointments List</h5>
                <a href="#" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Book Appointment
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold">09:30 AM</span></td>
                            <td>Sarah Johnson</td>
                            <td>Dr. Robert Smith</td>
                            <td>Checkup</td>
                            <td><span class="badge bg-warning-subtle text-warning">Confirmed</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle text-success"><i class="fa-solid fa-check"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle text-danger"><i class="fa-solid fa-xmark"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
