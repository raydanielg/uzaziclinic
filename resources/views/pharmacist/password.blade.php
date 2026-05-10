@extends('layouts.app')

@section('content')
<div class="pharmacist-password py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-danger">Change Password</h4>
                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Current Password</label>
                            <input type="password" class="form-control rounded-1 border-light bg-light shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">New Password</label>
                            <input type="password" class="form-control rounded-1 border-light bg-light shadow-none" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Confirm New Password</label>
                            <input type="password" class="form-control rounded-1 border-light bg-light shadow-none" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger rounded-1 px-5 fw-bold border-0">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
