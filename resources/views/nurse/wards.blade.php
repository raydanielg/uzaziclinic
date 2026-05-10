@extends('layouts.app')

@section('content')
<div class="nurse-wards py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Ward Management</h4>
                <p class="text-muted small">Overview of hospital wards and capacity.</p>
            </div>
            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0 fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Create Ward
            </button>
        </div>

        <div class="row g-4">
            @forelse($wards as $ward)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="bg-primary-soft text-primary p-3 rounded-4">
                            <i class="fa-solid fa-hospital fs-4"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <ul class="dropdown-menu border-0 shadow-sm">
                                <li><a class="dropdown-item small" href="#">Edit Ward</a></li>
                                <li><a class="dropdown-item small text-danger" href="#">Close Ward</a></li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $ward->name }}</h5>
                    <p class="text-muted small mb-3">{{ ucfirst($ward->type) }} Department</p>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small fw-bold">Beds</span>
                            <span class="small text-muted">{{ $ward->beds_count }} Total</span>
                        </div>
                        <div class="progress rounded-pill shadow-none" style="height: 6px;">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-3 border-top d-flex gap-2">
                        <a href="{{ route('nurse.bed-allocation') }}" class="btn btn-sm btn-light rounded-1 flex-grow-1 fw-bold">Manage Beds</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fa-solid fa-hospital fs-1 opacity-25 mb-3 d-block"></i>
                No wards registered.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
