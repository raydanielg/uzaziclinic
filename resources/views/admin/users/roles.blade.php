@extends('layouts.admin')

@section('page_title', 'Roles & Permissions')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 align-items-center animate__animated animate__fadeIn">
        <div class="col">
            <h4 class="fw-bold mb-1">Access Control</h4>
            <p class="text-muted small mb-0">Define system roles and manage their specific access permissions</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary px-4 shadow-sm" onclick="showNewRoleModal()">
                <i class="fa-solid fa-plus me-2"></i> Create New Role
            </button>
        </div>
    </div>

    <div class="row g-4 animate__animated animate__fadeInUp">
        @foreach($roles as $role)
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary-subtle text-primary rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ ucfirst($role->name) }}</h6>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ $role->users_count }} Active Users</span>
                        </div>
                    </div>
                    @if($role->name !== 'admin')
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmDeleteRole({{ $role->id }}, '{{ $role->name }}')">
                                <i class="fa-solid fa-trash-can me-2 small"></i> Delete Role
                            </a></li>
                        </ul>
                        <form id="delete-role-form-{{ $role->id }}" action="{{ route('admin.users.roles.destroy', $role->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @endif
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="permission-list mb-4" style="max-height: 250px; overflow-y: auto;">
                            @php $rolePerms = $role->getPermissionsArray(); @endphp
                            @foreach($availablePermissions as $key => $label)
                            <div class="form-check form-switch mb-2 py-1">
                                <input class="form-check-input shadow-none" type="checkbox" name="permissions[]" 
                                    value="{{ $key }}" id="perm_{{ $role->id }}_{{ $key }}"
                                    {{ (isset($rolePerms[$key]) || isset($rolePerms['all_access'])) ? 'checked' : '' }}
                                    {{ $role->name === 'admin' ? 'disabled' : '' }}>
                                <label class="form-check-label small text-dark ms-2 cursor-pointer" for="perm_{{ $role->id }}_{{ $key }}">
                                    {{ $label }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($role->name !== 'admin')
                        <div class="d-grid mt-auto">
                            <button type="submit" class="btn btn-outline-primary btn-sm rounded-2 py-2">
                                <i class="fa-solid fa-save me-2"></i> Update Permissions
                            </button>
                        </div>
                        @else
                        <div class="alert alert-light border-0 small mb-0 text-center py-2">
                            <i class="fa-solid fa-info-circle me-1"></i> Admin has full access by default.
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function confirmDeleteRole(id, name) {
        Swal.fire({
            title: 'Delete Role?',
            text: `Are you sure you want to delete the ${name} role? This cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-role-form-' + id).submit();
            }
        });
    }

    function showNewRoleModal() {
        Swal.fire({
            title: 'Create New Role',
            input: 'text',
            inputLabel: 'Role Name',
            inputPlaceholder: 'e.g. Supervisor',
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#6366f1',
            preConfirm: (name) => {
                if (!name) {
                    Swal.showValidationMessage('Role name is required')
                }
                return name;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Future implementation: Add AJAX call to create role
                Swal.fire('Info', 'Role creation will be implemented in the next update.', 'info');
            }
        });
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
    @endif
</script>
@endpush

<style>
    .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .permission-list::-webkit-scrollbar {
        width: 4px;
    }
    .permission-list::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .card-header .avatar {
        transition: transform 0.2s;
    }
    .card:hover .avatar {
        transform: scale(1.1);
    }
</style>
@endsection
