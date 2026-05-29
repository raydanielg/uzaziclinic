@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="row mb-4 anim-1">
            <div class="col">
                <h4 class="fw-bold mb-0">Add New Employee</h4>
                <p class="text-muted small mb-0">Register a new employee to the system</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.hr.index') }}" class="btn btn-light rounded-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to Employees
                </a>
            </div>
        </div>

        {{-- Form --}}
        <div class="dash-table-card anim-2">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.hr.store') }}">
                    @csrf
                    <div class="row g-3">
                        {{-- Personal Information --}}
                        <div class="col-12">
                            <h6 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-user me-2 text-blue"></i>Personal Information</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required placeholder="Enter first name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required placeholder="Enter last name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter email address">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required placeholder="Enter phone number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Address</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Enter residential address"></textarea>
                        </div>

                        {{-- Employment Information --}}
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold mb-3 pb-2 border-bottom"><i class="fa-solid fa-briefcase me-2 text-blue"></i>Employment Information</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Employment Type <span class="text-danger">*</span></label>
                            <select name="employment_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="full_time">Full Time</option>
                                <option value="part_time">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="intern">Intern</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Department <span class="text-danger">*</span></label>
                            <select name="department" class="form-select" required>
                                <option value="">Select Department</option>
                                <option value="medical">Medical</option>
                                <option value="nursing">Nursing</option>
                                <option value="admin">Admin</option>
                                <option value="lab">Lab</option>
                                <option value="pharmacy">Pharmacy</option>
                                <option value="hr">HR</option>
                                <option value="finance">Finance</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Position</label>
                            <input type="text" name="position" class="form-control" placeholder="Job title/position">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Hire Date</label>
                            <input type="date" name="hire_date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on_leave">On Leave</option>
                                <option value="terminated">Terminated</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Notes</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes or comments"></textarea>
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary rounded-2 px-4">
                                <i class="fa-solid fa-save me-2"></i>Save Employee
                            </button>
                            <a href="{{ route('admin.hr.index') }}" class="btn btn-light rounded-2 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
