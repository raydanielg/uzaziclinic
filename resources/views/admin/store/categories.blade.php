@extends('layouts.admin')

@section('page_title', 'Product Categories')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-tags text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Categories</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ count($categories) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Inventory Categories</h5>
                    <p class="text-muted small mb-0">Grouped overview of your store inventory by category</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.store.index') }}" class="btn btn-light rounded-1 px-4 shadow-sm border small">
                        <i class="fa-solid fa-boxes-stacked me-2"></i> View All Products
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="categoryTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 border-0">CATEGORY NAME</th>
                            <th class="border-0">TOTAL PRODUCTS</th>
                            <th class="border-0 text-center">STOCK STATUS</th>
                            <th class="text-end pe-4 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-folder-tree small"></i>
                                    </div>
                                    <span class="fw-bold text-dark text-uppercase small ls-1">{{ $category->category ?: 'Uncategorized' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="badge bg-light text-dark border-0 rounded-1 px-2 py-1 fw-bold">{{ $category->total }} Items</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">ACTIVE</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <a href="{{ route('admin.store.index', ['category' => $category->category]) }}" class="btn btn-sm btn-white border-0 py-1 px-3" title="View Products">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
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

<style>
    .avatar-sm { background-color: #f8fafc; }
    .table thead th {
        font-size: 0.7rem !important;
        letter-spacing: 1px;
        background: transparent !important;
        color: #94a3b8 !important;
        padding-bottom: 15px !important;
    }
    .btn-white { background: #fff; border: 1px solid #f1f5f9 !important; }
    .btn-white:hover { background: #f8fafc; }
    .ls-1 { letter-spacing: 0.5px; }
    .extra-small { font-size: 0.65rem; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories...",
                emptyTable: "No categories found."
            }
        });
    });
</script>
@endpush
