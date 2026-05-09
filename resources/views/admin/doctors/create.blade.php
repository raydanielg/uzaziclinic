@extends('layouts.admin')

@section('page_title', 'Create Doctor')

@section('content')
<div class="container-fluid px-0">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Add New Doctor</h5>
                        <a href="{{ route('admin.doctors.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.doctors.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control shadow-none @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control shadow-none @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone (Optional)</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control shadow-none @error('phone') is-invalid @enderror">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select shadow-none @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status','active')=='active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Specialization</label>
                                <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-control shadow-none @error('specialization') is-invalid @enderror" placeholder="e.g. Cardiology">
                                @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">License Number</label>
                                <input type="text" name="license_number" value="{{ old('license_number') }}" class="form-control shadow-none @error('license_number') is-invalid @enderror" placeholder="e.g. MED-2026-001">
                                @error('license_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control shadow-none" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold">Bio (Optional)</label>
                                <textarea name="bio" class="form-control shadow-none @error('bio') is-invalid @enderror" rows="4" placeholder="Short doctor profile...">{{ old('bio') }}</textarea>
                                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa-solid fa-check me-2"></i> Create Doctor
                                </button>
                                <a href="{{ route('admin.doctors.index') }}" class="btn btn-light px-5 ms-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
