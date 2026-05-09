@extends('layouts.admin')

@section('page_title', 'Pharmacy Stock')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-pills text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Medicines</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-triangle-exclamation text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Low Stock</p>
                    <h4 class="fw-bold mb-0">{{ $stats['low_stock'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-danger-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-xmark text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Expired</p>
                    <h4 class="fw-bold mb-0">{{ $stats['expired'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        @forelse($medicines ?? [] as $medicine)
                        <tr>
                            <td><span class="fw-bold">{{ $medicine->name }}</span></td>
                            <td>{{ $medicine->category }}</td>
                            <td>{{ $medicine->quantity }} Units</td>
                            <td>{{ $medicine->expiry_date?->format('M Y') ?? 'N/A' }}</td>
                            <td><span class="badge {{ $medicine->status_badge }}">{{ $medicine->status_label }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-pills fs-1 mb-2 d-block"></i>
                                No medicines found. Add your first medicine.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $medicines->links() ?? '' }}
        </div>
    </div>
</div>
@endsection
