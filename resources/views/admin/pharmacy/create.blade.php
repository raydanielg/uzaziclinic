@extends('layouts.admin')

@section('page_title', 'Add New Medicine')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Add New Medicine</h5>
                    <p class="text-muted small mb-0">Enter details to add a new product to your pharmacy stock</p>
                </div>
                <a href="{{ route('admin.pharmacy.stock') }}" class="btn btn-light rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Stock
                </a>
            </div>

            <form action="{{ route('admin.pharmacy.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Medicine Name</label>
                        <input type="text" name="name" class="form-control rounded-pill px-3 shadow-none @error('name') is-invalid @enderror" placeholder="e.g. Paracetamol" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                        <select name="category" class="form-select rounded-pill px-3 shadow-none @error('category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="Antibiotics">Antibiotics</option>
                            <option value="Painkillers">Painkillers</option>
                            <option value="Antipyretics">Antipyretics</option>
                            <option value="Antifungals">Antifungals</option>
                            <option value="Supplements">Supplements</option>
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Quantity (Units)</label>
                        <input type="number" name="quantity" class="form-control rounded-pill px-3 shadow-none @error('quantity') is-invalid @enderror" placeholder="e.g. 100" required>
                        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Price per Unit</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-pill px-3 shadow-none @error('price') is-invalid @enderror" placeholder="e.g. 500.00" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control rounded-pill px-3 shadow-none @error('expiry_date') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
                        @error('expiry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Description (Optional)</label>
                        <textarea name="description" class="form-control rounded-4 px-3 shadow-none" rows="3" placeholder="Additional details about the medicine..."></textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="reset" class="btn btn-light rounded-pill px-4 me-2 shadow-none border">Reset</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Save Medicine
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        height: 45px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #6366f1;
    }
</style>
@endsection
