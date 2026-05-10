@extends('layouts.app')

@section('content')
<div class="doctor-password py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden position-relative">
                    <div class="position-absolute end-0 top-0 p-4 opacity-10">
                        <i class="fa-solid fa-key fa-6x"></i>
                    </div>
                    <div class="position-relative">
                        <h4 class="fw-bold mb-1 text-primary">Change Password</h4>
                        <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Current Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-light text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" name="current_password" class="form-control rounded-1 border-light bg-light shadow-none py-2" placeholder="Enter current password" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-light text-muted"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="new_password" class="form-control rounded-1 border-light bg-light shadow-none py-2" placeholder="Enter new password" required>
                                </div>
                                <div class="form-text small">Password must be at least 8 characters long.</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-light text-muted"><i class="fa-solid fa-shield-check"></i></span>
                                    <input type="password" name="new_password_confirmation" class="form-control rounded-1 border-light bg-light shadow-none py-2" placeholder="Repeat new password" required>
                                </div>
                            </div>

                            <div class="col-md-12 text-end pt-3 border-top">
                                <button type="submit" class="btn btn-primary rounded-1 px-5 py-2 shadow-sm border-0 fw-bold">
                                    <i class="fa-solid fa-shield-halved me-2"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Security Tips Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mt-4 bg-light">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-circle-info me-2 text-info"></i>Security Tips</h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2 d-flex align-items-start">
                            <i class="fa-solid fa-check text-success me-2 mt-1"></i>
                            <span>Use a mix of uppercase and lowercase letters.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start">
                            <i class="fa-solid fa-check text-success me-2 mt-1"></i>
                            <span>Include numbers and special characters like (!@#$).</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fa-solid fa-check text-success me-2 mt-1"></i>
                            <span>Avoid using common words or personal information.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .input-group-text { border-right: 0; }
    .input-group .form-control { border-left: 0; }
</style>
@endsection
