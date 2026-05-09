@extends('layouts.admin')

@section('page_title', 'Inventory Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-pills text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Items</p>
                    <h4 class="fw-bold mb-0">{{ $totalItems ?? 0 }}</h4>
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
                    <h4 class="fw-bold mb-0">{{ $lowStock ?? 0 }}</h4>
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
                    <p class="text-muted mb-0 small">Expiring Soon</p>
                    <h4 class="fw-bold mb-0">{{ $expiringSoon ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Stock by Category</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Category</th>
                            <th>Items</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byCategory ?? [] as $row)
                        <tr>
                            <td><span class="fw-bold">{{ $row->category }}</span></td>
                            <td>{{ $row->total }}</td>
                            <td>{{ $row->qty }} Units</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No inventory data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
