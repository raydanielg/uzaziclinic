@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="fw-bold mb-1">System Users</h4>
                            <p class="text-muted mb-0">Manage all administrative and medical staff accounts</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                                <i class="fa-solid fa-plus me-2"></i> Add New User
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted fw-semibold text-uppercase small" style="width: 300px;">User Details</th>
                                    <th class="py-3 text-muted fw-semibold text-uppercase small">Role</th>
                                    <th class="py-3 text-muted fw-semibold text-uppercase small">Contact</th>
                                    <th class="py-3 text-muted fw-semibold text-uppercase small">Status</th>
                                    <th class="py-3 text-muted fw-semibold text-uppercase small">Joined Date</th>
                                    <th class="pe-4 py-3 text-end text-muted fw-semibold text-uppercase small">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users ?? [] as $user)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-container me-3">
                                                <div class="avatar bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 1.1rem;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill fw-medium">
                                            <i class="fa-solid fa-shield-halved me-1 small"></i>
                                            {{ ucfirst($user->role->name ?? 'User') }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-muted">
                                        {{ $user->phone ?? 'N/A' }}
                                    </td>
                                    <td class="py-3">
                                        @if($user->status == 'active')
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-medium">
                                                <span class="d-inline-block rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-medium">
                                                <span class="d-inline-block rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-muted small">
                                        {{ $user->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" title="Edit User">
                                                <i class="fa-solid fa-pen-to-square text-primary"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" title="Delete User">
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fa-solid fa-users-slash fs-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">No users found</h5>
                                            <p class="small text-muted mb-0">Try adding a new user to the system.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if(isset($users) && method_exists($users, 'links'))
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
