@extends('layouts.admin')

@section('page_title', 'Doctor Specializations')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Medical Specializations</h5>
                <button class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i> Add Specialization
                </button>
            </div>
            
            <div class="row g-4">
                @forelse($specializations as $spec)
                    <div class="col-md-4">
                        <div class="card border border-light shadow-sm rounded-3 hover-shadow transition">
                            <div class="card-body p-4 text-center">
                                <div class="avatar-lg bg-primary-subtle text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fa-solid fa-stethoscope fs-4"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $spec }}</h6>
                                <p class="text-muted small mb-0">View all doctors in this field</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        No specializations found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection
