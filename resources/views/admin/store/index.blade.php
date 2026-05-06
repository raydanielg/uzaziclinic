@extends('layouts.admin')

@section('page_title', 'E-commerce Store')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Product Catalog</h5>
                <a href="{{ route('admin.store.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Add Product
                </a>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fa-solid fa-baby fa-4x text-muted opacity-25"></i>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1">Baby Care Set</h6>
                            <p class="text-muted small mb-2">Maternity Products</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">TSh 85,000</span>
                                <span class="badge bg-success-subtle text-success">12 in Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fa-solid fa-bottle-water fa-4x text-muted opacity-25"></i>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1">Maternity Milk</h6>
                            <p class="text-muted small mb-2">Nutrition</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">TSh 45,000</span>
                                <span class="badge bg-danger-subtle text-danger">Out of Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
