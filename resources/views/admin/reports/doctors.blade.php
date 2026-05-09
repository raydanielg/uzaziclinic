@extends('layouts.admin')

@section('page_title', 'Doctor Performance Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-doctor text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Doctors</p>
                    <h4 class="fw-bold mb-0">{{ $totalDoctors ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-check text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Active Doctors</p>
                    <h4 class="fw-bold mb-0">{{ $activeDoctors ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Doctor Appointments This Month</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>Appointments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors ?? [] as $doctor)
                        <tr>
                            <td><span class="fw-bold">{{ $doctor->user->name ?? 'N/A' }}</span></td>
                            <td>{{ $doctor->specialization ?? 'General' }}</td>
                            <td>{{ $doctor->appointments_count ?? 0 }}</td>
                            <td><span class="badge {{ $doctor->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">{{ ucfirst($doctor->status ?? 'inactive') }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No doctors found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
