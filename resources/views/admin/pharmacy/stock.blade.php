@extends('layouts.admin')

@section('page_title', 'Pharmacy Stock')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Medicines Inventory</h5>
                <a href="{{ route('admin.pharmacy.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Add Medicine
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold">Paracetamol 500mg</span></td>
                            <td>General</td>
                            <td>450 Units</td>
                            <td>Dec 2027</td>
                            <td><span class="badge bg-success-subtle text-success">In Stock</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="fw-bold text-danger">Amoxicillin</span></td>
                            <td>Antibiotic</td>
                            <td>5 Units</td>
                            <td>Jun 2026</td>
                            <td><span class="badge bg-danger-subtle text-danger">Low Stock</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
