@extends('layouts.app')

@section('content')
<div class="pharmacist-stock-summary py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Stock Summary</h4>
                <p class="text-muted small">Overview of inventory levels and health.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white">
                    <h6 class="small text-uppercase fw-bold opacity-75">Total Stock Value</h6>
                    <h2 class="fw-bold mb-0">TZS {{ number_format($total_value) }}</h2>
                    <p class="small mb-0 mt-2"><i class="fa-solid fa-arrow-up me-1"></i> 5% from last month</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-danger text-white">
                    <h6 class="small text-uppercase fw-bold opacity-75">Out of Stock Items</h6>
                    <h2 class="fw-bold mb-0">{{ $out_of_stock_count }}</h2>
                    <p class="small mb-0 mt-2">Requires immediate attention</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-warning text-dark">
                    <h6 class="small text-uppercase fw-bold opacity-75">Expiring Soon</h6>
                    <h2 class="fw-bold mb-0">{{ $expiring_count }}</h2>
                    <p class="small mb-0 mt-2 text-muted">Within next 30 days</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">Category Distribution</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Category</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Total Items</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Current Value</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category_summary as $cat)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $cat->category }}</td>
                            <td>{{ $cat->count }}</td>
                            <td>TZS {{ number_format($cat->value) }}</td>
                            <td class="text-end pe-4">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Healthy</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
