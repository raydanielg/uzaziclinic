@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">System Users</h5>
                        <button type="button" class="btn btn-primary rounded-1 px-4 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fa-solid fa-plus me-2"></i> Add User
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-2">USER DETAILS</th>
                                    <th>ROLE</th>
                                    <th>CONTACT</th>
                                    <th>STATUS</th>
                                    <th>JOINED</th>
                                    <th class="text-end pe-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr id="user-row-{{ $user->id }}">
                                    <td class="ps-3">
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
                                    <td>
                                        <select class="form-select form-select-sm role-select rounded-1 border-light bg-light" data-user-id="{{ $user->id }}" style="max-width: 180px;">
                                            @foreach(($roles ?? []) as $role)
                                                <option value="{{ $role->id }}" {{ (int)$user->role_id === (int)$role->id ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $user->phone ?? '---' }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" data-user-id="{{ $user->id }}" {{ $user->status == 'active' ? 'checked' : '' }}>
                                            <span class="badge {{ $user->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} status-badge-{{ $user->id }} border-0 px-2 py-1 ms-1">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-white border-0 py-1 px-3" title="Edit">
                                                <i class="fa-solid fa-pen text-primary small"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-white border-0 py-1 px-3" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Delete">
                                                <i class="fa-solid fa-trash text-danger small"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
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
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control shadow-none" required placeholder="Enter full name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control shadow-none" required placeholder="email@example.com">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control shadow-none" placeholder="e.g. +255...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role_id" class="form-select shadow-none" required>
                                <option value="">Select Role</option>
                                @foreach(\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control shadow-none" required placeholder="Min. 8 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control shadow-none" required placeholder="Repeat password">
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

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa-solid fa-file-pdf me-2"></i> Export to PDF',
                    className: 'btn btn-outline-danger btn-sm px-3',
                    title: 'System Users Report',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function(doc) {
                        doc.content[1].table.widths = ['30%', '20%', '20%', '15%', '15%'];
                        doc.styles.tableHeader = {
                            fillColor: '#6366f1',
                            color: 'white',
                            alignment: 'left',
                            bold: true,
                            fontSize: 10
                        };
                        doc.defaultStyle.fontSize = 9;
                        doc.content.splice(0, 1, {
                            text: 'DRISSA AFYA CARE - USER REPORT',
                            fontSize: 18,
                            bold: true,
                            alignment: 'center',
                            margin: [0, 0, 0, 20],
                            color: '#6366f1'
                        });
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa-solid fa-print me-2"></i> Print',
                    className: 'btn btn-outline-secondary btn-sm px-3'
                }
            ],
            lengthMenu: [ [10, 50, -1], [10, 50, "All"] ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search users...",
                lengthMenu: "Show _MENU_ entries"
            }
        });

        // Delete Confirmation
        window.confirmDelete = function(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete: " + name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Inline Role Change (AJAX)
        $('.role-select').on('change', function() {
            const userId = $(this).data('user-id');
            const roleId = $(this).val();
            const $select = $(this);

            $.ajax({
                url: `{{ url('admin/users') }}/${userId}/role`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    role_id: roleId
                },
                success: function(resp) {
                    if (resp && resp.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: resp.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update role.' });
                    }
                },
                error: function(xhr) {
                    let msg = 'Failed to update role.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    // revert selection
                    $select.val($select.data('current'));
                }
            });
        }).each(function() {
            $(this).data('current', $(this).val());
        });
    });

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
    @endif
</script>
@endpush

<style>
    .dataTables_length select {
        padding: 0.3rem 2rem 0.3rem 0.75rem !important;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }
    .dataTables_filter input {
        padding: 0.3rem 0.75rem !important;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        outline: none;
    }
    .table thead th {
        font-size: 0.75rem !important;
        letter-spacing: 0.5px;
        background: #f8fafc !important;
        color: #64748b !important;
        border-bottom: 2px solid #e2e8f0 !important;
    }
    .dt-buttons .btn {
        margin-right: 5px;
        border-radius: 4px !important;
    }
    .table thead th {
        font-size: 0.7rem !important;
        letter-spacing: 0.5px;
        background: #fcfdfe !important;
        text-transform: uppercase;
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
</style>
@endsection
