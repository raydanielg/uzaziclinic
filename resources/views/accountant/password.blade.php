@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Change Password</h1>
                <p class="text-muted small mb-0">Update your account password regularly to stay secure.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-lock me-2 text-primary"></i>Update Password</h5>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success rounded-3 border-0">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="#">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" class="form-control" placeholder="Current password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this)"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="New password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePwd(this)"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-2 py-2">
                                    <i class="fa-solid fa-key me-2"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function togglePwd(btn) {
    const input = btn.previousElementSibling;
    const icon = btn.querySelector('i');
    if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye','fa-eye-slash'); }
    else { input.type = 'password'; icon.classList.replace('fa-eye-slash','fa-eye'); }
}
</script>
@endpush
@endsection
