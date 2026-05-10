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
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-danger-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-arrow-trend-down text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Low Stock</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $lowStock ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-hourglass-half text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Expiring Soon</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $expiringSoon ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-1 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Category Distribution</h5>
                    <p class="text-muted small mb-0">Medicine inventory by category</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">CATEGORY</th>
                            <th class="border-0">TOTAL ITEMS</th>
                            <th class="border-0">TOTAL QTY</th>
                            <th class="border-0">HEALTH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byCategory as $cat)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-dark text-uppercase small ls-1">{{ $cat->category ?: 'General' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border-0 rounded-1 px-2 py-1 fw-bold">{{ $cat->total }} Items</span>
                            </td>
                            <td>
                                <span class="text-dark fw-bold small">{{ number_format($cat->qty) }}</span>
                            </td>
                            <td>
                                @php $health = $cat->qty > 50 ? 'success' : ($cat->qty > 10 ? 'warning' : 'danger'); @endphp
                                <div class="progress" style="height: 4px; width: 60px;">
                                    <div class="progress-bar bg-{{ $health }}" style="width: 100%"></div>
                                </div>
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
