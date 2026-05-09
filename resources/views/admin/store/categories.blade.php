@extends('layouts.admin')

@section('page_title', 'Product Categories')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Product Categories</h5>
                <a href="{{ route('admin.store.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Add Product
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Category</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories ?? [] as $category)
                        <tr>
                            <td><span class="fw-bold">{{ $category->category ?: 'Uncategorized' }}</span></td>
                            <td>{{ $category->total }}</td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="fa-solid fa-tags fs-1 mb-2 d-block"></i>
                                No categories found. Add products to create categories.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
