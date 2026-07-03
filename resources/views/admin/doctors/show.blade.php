@extends('layouts.admin')

@section('page_title', 'Doctor Details')

@section('content')
<div class="container-fluid px-0">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Doctor Details</h5>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Full Name</label>
                            <div class="fw-semibold">{{ $doctor->display_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email</label>
                            <div class="fw-semibold">{{ $doctor->user->email ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Phone</label>
                            <div class="fw-semibold">{{ $doctor->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Status</label>
                            <div>
                                <span class="badge {{ $doctor->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($doctor->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Specialization</label>
                            <div class="fw-semibold">{{ $doctor->specialization ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">License Number</label>
                            <div class="fw-semibold">{{ $doctor->license_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Bio</label>
                            <div class="text-muted">{{ $doctor->bio ?? 'No bio provided.' }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fa-solid fa-pen me-2"></i> Edit
                        </a>
                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4 ms-2 shadow-sm">
                                <i class="fa-solid fa-trash me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
