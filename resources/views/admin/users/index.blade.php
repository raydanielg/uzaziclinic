@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="fw-bold mb-0">System Users</h5>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fa-solid fa-plus me-2"></i> Add New User
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted fw-semibold small">USER DETAILS</th>
                                    <th class="py-3 text-muted fw-semibold small">ROLE</th>
                                    <th class="py-3 text-muted fw-semibold small">CONTACT</th>
                                    <th class="py-3 text-muted fw-semibold small">STATUS</th>
                                    <th class="py-3 text-muted fw-semibold small">JOINED</th>
                                    <th class="pe-4 py-3 text-end text-muted fw-semibold small">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users ?? [] as $user)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary-subtle text-primary rounded-1 d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-primary border px-2 py-1 fw-normal">
                                            {{ ucfirst($user->role->name ?? 'User') }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-muted small">
                                        {{ $user->phone ?? '---' }}
                                    </td>
                                    <td class="py-3">
                                        @if($user->status == 'active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-normal">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fw-normal">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-muted small">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="editUser({{ $user->id }})" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title fw-bold">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control shadow-none" required placeholder="Enter full name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control shadow-none" required placeholder="email@example.com">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role_id" class="form-select shadow-none" required>
                                <option value="">Select Role</option>
                                @foreach(\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select shadow-none" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete user: " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapa utaweka AJAX au form submission kwa ajili ya kufuta
                Swal.fire(
                    'Deleted!',
                    'User has been deleted successfully.',
                    'success'
                )
            }
        })
    }

    function editUser(id) {
        // Hapa utafetch data ya user na kuifungua kwenye modal
        Swal.fire({
            title: 'Edit User',
            text: 'Fetching user details...',
            icon: 'info',
            timer: 1000,
            showConfirmButton: false
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>

@style
    .table thead th {
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        background: #fcfdfe;
    }
    .btn-group .btn {
        padding: 0.25rem 0.6rem;
    }
    .modal-content {
        border-radius: 8px;
    }
    .form-control, .form-select {
        border-radius: 4px;
        font-size: 0.9rem;
    }
    .btn {
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9rem;
    }
@endstyle
@endsection
