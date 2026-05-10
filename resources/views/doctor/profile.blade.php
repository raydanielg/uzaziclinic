@extends('layouts.app')

@section('content')
<div class="doctor-profile py-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Overview Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px;">
                            <i class="fa-solid fa-user-doctor fa-4x"></i>
                        </div>
                        <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0 p-2 shadow">
                            <i class="fa-solid fa-camera small"></i>
                        </button>
                    </div>
                    <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted small mb-3">Specialist Doctor</p>
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">Active</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">Staff ID: #DOC-{{ Auth::user()->id }}</span>
                    </div>
                    <hr class="border-light opacity-50">
                    <div class="text-start mt-4">
                        <h6 class="fw-bold small text-uppercase ls-1 text-muted mb-3">Contact Information</h6>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-envelope text-primary me-3"></i>
                            <span class="small">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-phone text-success me-3"></i>
                            <span class="small">{{ Auth::user()->phone ?? '+255 000 000 000' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-user-gear me-2 text-primary"></i>Profile Settings</h5>
                    
                    <form>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Full Name</label>
                                <input type="text" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Email Address</label>
                                <input type="email" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Phone Number</label>
                                <input type="text" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->phone ?? '' }}" placeholder="+255 ...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Specialization</label>
                                <select class="form-select rounded-1 border-light bg-light shadow-none">
                                    <option>Obstetrician & Gynecologist</option>
                                    <option>Pediatrician</option>
                                    <option>General Practitioner</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Biography / About</label>
                                <textarea class="form-control rounded-1 border-light bg-light shadow-none" rows="4" placeholder="Brief info about your medical experience..."></textarea>
                            </div>
                            <div class="col-md-12 text-end pt-3">
                                <button type="button" class="btn btn-primary rounded-1 px-5 py-2 shadow-sm border-0 fw-bold">
                                    <i class="fa-solid fa-save me-2"></i> Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Professional Details -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-briefcase me-2 text-info"></i>Work Information</h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-1 border border-light">
                                <div class="small text-muted mb-1 text-uppercase ls-1 fw-bold" style="font-size: 0.65rem;">Joined Date</div>
                                <div class="fw-bold text-dark small">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-1 border border-light">
                                <div class="small text-muted mb-1 text-uppercase ls-1 fw-bold" style="font-size: 0.65rem;">Total Reviews</div>
                                <div class="fw-bold text-dark small">128 Positive</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-1 border border-light">
                                <div class="small text-muted mb-1 text-uppercase ls-1 fw-bold" style="font-size: 0.65rem;">Avg. Rating</div>
                                <div class="text-warning small">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <span class="ms-1 fw-bold text-dark">4.8</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
