@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">My Profile</h1>
                <p class="text-muted small mb-0">Manage your personal and professional information.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width:100px;height:100px;font-size:2.5rem;">
                            <i class="fa-solid fa-user-nurse"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-1">{{ Auth::user()->email }}</p>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Nurse</span>
                    <hr class="my-3">
                    <div class="text-start">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-envelope me-2 text-muted" style="width:20px;"></i>
                            <span class="small">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-phone me-2 text-muted" style="width:20px;"></i>
                            <span class="small">{{ Auth::user()->phone ?? 'Not set' }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-calendar me-2 text-muted" style="width:20px;"></i>
                            <span class="small">Joined {{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="#">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" placeholder="+255 7XX XXX XXX">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Department</label>
                                    <select class="form-select">
                                        <option>General Ward</option>
                                        <option>Maternity</option>
                                        <option>Emergency</option>
                                        <option>Pediatrics</option>
                                        <option>ICU</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Address</label>
                                    <textarea name="address" class="form-control" rows="2" placeholder="Your physical address...">{{ Auth::user()->address ?? '' }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-2 px-4">
                                        <i class="fa-solid fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.15); }
</style>
@endsection
