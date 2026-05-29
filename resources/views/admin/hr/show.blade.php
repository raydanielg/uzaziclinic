@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="row mb-4 anim-1">
            <div class="col">
                <h4 class="fw-bold mb-0">Employee Details</h4>
                <p class="text-muted small mb-0">View employee information</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.hr.index') }}" class="btn btn-light rounded-2">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to Employees
                </a>
            </div>
        </div>

        {{-- Employee Info --}}
        <div class="row g-4 anim-2">
            {{-- Personal Information --}}
            <div class="col-md-6">
                <div class="dash-table-card">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0"><i class="fa-solid fa-user me-2 text-blue"></i>Personal Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted">Employee Number</label>
                            <div class="fw-semibold">{{ $employee->employee_number }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Full Name</label>
                            <div class="fw-semibold">{{ $employee->full_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Email</label>
                            <div class="fw-semibold">{{ $employee->email }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Phone</label>
                            <div class="fw-semibold">{{ $employee->phone }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Gender</label>
                            <div class="fw-semibold">{{ ucfirst($employee->gender ?? 'N/A') }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Date of Birth</label>
                            <div class="fw-semibold">{{ $employee->date_of_birth ? $employee->date_of_birth->format('d M Y') : 'N/A' }}</div>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted">Address</label>
                            <div class="fw-semibold">{{ $employee->address ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Employment Information --}}
            <div class="col-md-6">
                <div class="dash-table-card">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0"><i class="fa-solid fa-briefcase me-2 text-blue"></i>Employment Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small text-muted">Employment Type</label>
                            <div class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $employee->employment_type)) }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Department</label>
                            <div class="fw-semibold">{{ ucfirst($employee->department) }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Position</label>
                            <div class="fw-semibold">{{ $employee->position ?? 'N/A' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Hire Date</label>
                            <div class="fw-semibold">{{ $employee->hire_date ? $employee->hire_date->format('d M Y') : 'N/A' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Status</label>
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-soft text-green',
                                    'inactive' => 'bg-gray-soft text-gray',
                                    'on_leave' => 'bg-amber-soft text-amber',
                                    'terminated' => 'bg-rose-soft text-rose',
                                ];
                            @endphp
                            <span class="status-badge {{ $statusColors[$employee->status] ?? 'bg-gray-soft text-gray' }}">
                                {{ ucfirst(str_replace('_', ' ', $employee->status)) }}
                            </span>
                        </div>
                        <div class="mb-0">
                            <label class="small text-muted">Notes</label>
                            <div class="fw-semibold">{{ $employee->notes ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="row mt-4 anim-3">
            <div class="col-12">
                <div class="dash-table-card">
                    <div class="card-body">
                        <a href="{{ route('admin.hr.edit', $employee) }}" class="btn btn-primary rounded-2 px-4">
                            <i class="fa-solid fa-pen me-2"></i>Edit Employee
                        </a>
                        <form action="{{ route('admin.hr.destroy', $employee) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-2 px-4 ms-2" onclick="return confirm('Are you sure you want to delete this employee?')">
                                <i class="fa-solid fa-trash me-2"></i>Delete Employee
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
