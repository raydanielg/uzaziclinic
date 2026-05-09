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
            
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-primary-soft text-primary me-3">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase">Total Products</h6>
                        <h4 class="mb-0 fw-bold">{{ $stats['total_products'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-success-soft text-success me-3">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase">Active Orders</h6>
                        <h4 class="mb-0 fw-bold">{{ $stats['active_orders'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-warning-soft text-warning me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small text-uppercase">Low Stock Items</h6>
                        <h4 class="mb-0 fw-bold">{{ $stats['low_stock'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">Product List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Bidhaa</th>
                            <th>Category</th>
                            <th>Bei (TZS)</th>
                            <th>Stock</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="product-img me-3">
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;">{{ $product->description }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border rounded-pill">{{ $product->category ?? 'N/A' }}</span></td>
                            <td class="fw-bold text-dark">{{ number_format($product->price, 0) }}/=</td>
                            <td>
                                @if($product->stock_quantity <= 5)
                                    <span class="text-danger fw-bold"><i class="fas fa-arrow-down me-1"></i>{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="text-success fw-bold">{{ $product->stock_quantity }}</span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock_quantity > 0)
                                    <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">In Stock</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger rounded-pill px-3 py-2">Out of Stock</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border shadow-none" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2 text-success"></i>Hariri</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Futa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3 opacity-20"></i>
                                    <p class="mb-0">Hakuna bidhaa iliyopatikana kwenye duka.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    
    .icon-box {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
</style>
@endsection
