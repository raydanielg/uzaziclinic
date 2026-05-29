@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        {{-- Header --}}
        <div class="row mb-4 anim-1">
            <div class="col">
                <h4 class="fw-bold mb-0">Human Resources</h4>
                <p class="text-muted small mb-0">Manage employees and staff information</p>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.hr.create') }}" class="btn btn-primary rounded-2 shadow-sm px-4">
                    <i class="fa-solid fa-user-plus me-2"></i>Add Employee
                </a>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="row g-3 mb-4 anim-2">
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-blue">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-blue"><i class="fa-solid fa-users"></i></div>
                        <div><div class="stat-label">Total Employees</div>
                        <div class="stat-value">{{ \App\Models\Employee::count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-green">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-user-check"></i></div>
                        <div><div class="stat-label">Active</div>
                        <div class="stat-value">{{ \App\Models\Employee::where('status', 'active')->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-amber">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-user-clock"></i></div>
                        <div><div class="stat-label">On Leave</div>
                        <div class="stat-value">{{ \App\Models\Employee::where('status', 'on_leave')->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-cyan">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-briefcase"></i></div>
                        <div><div class="stat-label">Departments</div>
                        <div class="stat-value">{{ \App\Models\Employee::distinct('department')->count('department') }}</div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="dash-table-card anim-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-users me-2 text-blue"></i>All Employees</h6>
                <div class="d-flex gap-2">
                    <select id="filterDepartment" class="form-select form-select-sm" style="width:150px">
                        <option value="">All Departments</option>
                        <option value="medical">Medical</option>
                        <option value="nursing">Nursing</option>
                        <option value="admin">Admin</option>
                        <option value="lab">Lab</option>
                        <option value="pharmacy">Pharmacy</option>
                        <option value="hr">HR</option>
                        <option value="finance">Finance</option>
                        <option value="other">Other</option>
                    </select>
                    <select id="filterStatus" class="form-select form-select-sm" style="width:150px">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="on_leave">On Leave</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Employee #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr data-department="{{ $employee->department }}" data-status="{{ $employee->status }}">
                            <td class="ps-3 text-muted small">{{ $employee->employee_number }}</td>
                            <td>
                                <div class="fw-semibold small">{{ $employee->full_name }}</div>
                            </td>
                            <td class="small text-muted">{{ $employee->email }}</td>
                            <td class="small">{{ $employee->phone }}</td>
                            <td class="small">{{ ucfirst($employee->department) }}</td>
                            <td class="small text-muted">{{ $employee->position ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-soft text-green',
                                        'inactive' => 'bg-gray-soft text-gray',
                                        'on_leave' => 'bg-amber-soft text-amber',
                                        'terminated' => 'bg-rose-soft text-rose',
                                    ];
                                    $statusIcon = [
                                        'active' => 'fa-circle-check',
                                        'inactive' => 'fa-circle-xmark',
                                        'on_leave' => 'fa-clock',
                                        'terminated' => 'fa-ban',
                                    ];
                                @endphp
                                <span class="status-badge {{ $statusColors[$employee->status] ?? 'bg-gray-soft text-gray' }}">
                                    <i class="fa-solid {{ $statusIcon[$employee->status] ?? 'fa-circle' }} me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $employee->status)) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.hr.show', $employee) }}" class="btn btn-sm btn-light me-1 rounded-2" title="View">
                                    <i class="fa-solid fa-eye text-blue"></i>
                                </a>
                                <a href="{{ route('admin.hr.edit', $employee) }}" class="btn btn-sm btn-light me-1 rounded-2" title="Edit">
                                    <i class="fa-solid fa-pen text-amber"></i>
                                </a>
                                <form action="{{ route('admin.hr.destroy', $employee) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-2" title="Delete" onclick="return confirm('Are you sure you want to delete this employee?')">
                                        <i class="fa-solid fa-trash text-rose"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users-slash fs-2 d-block mb-2 opacity-25"></i>
                                No employees found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($employees->hasPages())
            <div class="px-3 py-2 border-top bg-white">{{ $employees->links() }}</div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#filterDepartment, #filterStatus').on('change', function() {
        const dept = $('#filterDepartment').val();
        const status = $('#filterStatus').val();
        
        $('tbody tr').each(function() {
            const rowDept = $(this).data('department');
            const rowStatus = $(this).data('status');
            
            let show = true;
            if (dept && rowDept !== dept) show = false;
            if (status && rowStatus !== status) show = false;
            
            $(this).toggle(show);
        });
    });
});
</script>
@endpush
@endsection
