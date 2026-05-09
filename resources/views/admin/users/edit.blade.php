@extends('layouts.admin')

@section('page_title', 'Edit User')

@section('content')
<div class="container-fluid px-0">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Edit User Profile</h5>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control shadow-none @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control shadow-none @error('email') is-invalid @enderror" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control shadow-none @error('phone') is-invalid @enderror">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label small fw-bold">Role</label>
                                <select name="role_id" class="form-select shadow-none @error('role_id') is-invalid @enderror" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label small fw-bold">Status</label>
                                <select name="status" class="form-select shadow-none @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="bg-light p-3 rounded mb-4">
                            <h6 class="fw-bold mb-3"><i class="fa-solid fa-lock me-2 text-primary"></i> Change Password</h6>
                            <p class="text-muted small mb-3">Leave these fields empty if you don't want to change the password.</p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">New Password</label>
                                    <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror" placeholder="Enter new password">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control shadow-none" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-5">Update User Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 4px;
        padding: 0.6rem 0.75rem;
        border: 1px solid #e2e8f0;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
    }
    .btn {
        border-radius: 4px;
        font-weight: 500;
        padding: 0.6rem 1.25rem;
    }
</style>
@endsection

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
