@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-plus me-2"></i>Add New Service</h4>
            <p class="text-muted small mb-0">Create a new clinic service</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.services.index') }}" class="btn btn-light fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Service Name *</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g., Doctor Consultation">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Price (TZS) *</label>
                        <input type="number" name="price" class="form-control" required min="0" step="0.01" placeholder="e.g., 700000">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Describe the service..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary fw-semibold rounded-2 px-4">
                        <i class="fa-solid fa-save me-2"></i>Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
