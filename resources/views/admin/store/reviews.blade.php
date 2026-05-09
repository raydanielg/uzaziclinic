@extends('layouts.admin')

@section('page_title', 'Product Reviews')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Product Reviews</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-star fs-1 mb-2 d-block"></i>
                                No reviews found yet.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
