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
                        <div><div class="stat-label">Total Staff</div>
                        <div class="stat-value">{{ $allStaff->total() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-green">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-green"><i class="fa-solid fa-user-doctor"></i></div>
                        <div><div class="stat-label">Doctors</div>
                        <div class="stat-value">{{ \App\Models\Doctor::count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-amber">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-amber"><i class="fa-solid fa-user-nurse"></i></div>
                        <div><div class="stat-label">Nurses</div>
                        <div class="stat-value">{{ \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'nurse'))->count() }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-modern stat-card-cyan">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon stat-card-cyan"><i class="fa-solid fa-user-tie"></i></div>
                        <div><div class="stat-label">Other Staff</div>
                        <div class="stat-value">{{ \App\Models\Employee::count() }}</div></div>
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
                        @forelse($allStaff as $staff)
                        <tr data-department="{{ $staff['department'] }}" data-status="{{ $staff['status'] }}">
                            <td class="ps-3 text-muted small">
                                {{ $staff['employee_number'] }}
                                @if($staff['type'] === 'doctor')
                                    <span class="badge bg-green-soft text-green ms-1" style="font-size:0.65rem">DR</span>
                                @elseif($staff['type'] === 'nurse')
                                    <span class="badge bg-pink-soft text-pink ms-1" style="font-size:0.65rem">NR</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold small">{{ $staff['name'] }}</div>
                            </td>
                            <td class="small text-muted">{{ $staff['email'] }}</td>
                            <td class="small">{{ $staff['phone'] }}</td>
                            <td class="small">{{ ucfirst($staff['department']) }}</td>
                            <td class="small text-muted">{{ $staff['position'] ?? 'N/A' }}</td>
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
                                <span class="status-badge {{ $statusColors[$staff['status']] ?? 'bg-gray-soft text-gray' }}">
                                    <i class="fa-solid {{ $statusIcon[$staff['status']] ?? 'fa-circle' }} me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $staff['status'])) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                @if($staff['type'] === 'employee')
                                    <a href="{{ route('admin.hr.show', $staff['id']) }}" class="btn btn-sm btn-light me-1 rounded-2" title="View">
                                        <i class="fa-solid fa-eye text-blue"></i>
                                    </a>
                                    <a href="{{ route('admin.hr.edit', $staff['id']) }}" class="btn btn-sm btn-light me-1 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen text-amber"></i>
                                    </a>
                                    <form action="{{ route('admin.hr.destroy', $staff['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-2" title="Delete" onclick="return confirm('Are you sure you want to delete this employee?')">
                                            <i class="fa-solid fa-trash text-rose"></i>
                                        </button>
                                    </form>
                                @elseif($staff['type'] === 'doctor')
                                    <a href="{{ route('admin.doctors.show', $staff['id']) }}" class="btn btn-sm btn-light me-1 rounded-2" title="View">
                                        <i class="fa-solid fa-eye text-blue"></i>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $staff['id']) }}" class="btn btn-sm btn-light me-1 rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen text-amber"></i>
                                    </a>
                                @else
                                    <span class="text-muted small" title="Manage via User Accounts">
                                        <i class="fa-solid fa-user-gear text-secondary"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users-slash fs-2 d-block mb-2 opacity-25"></i>
                                No staff found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($allStaff->hasPages())
            <div class="px-3 py-2 border-top bg-white">{{ $allStaff->links() }}</div>
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
