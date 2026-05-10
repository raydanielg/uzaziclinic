@extends('layouts.admin')

@section('page_title', 'E-commerce Store')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-boxes-stacked text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Products</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_products'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-cart-shopping text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Active Orders</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['active_orders'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-triangle-exclamation text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Low Stock</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['low_stock'] }}</h4>
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
                    <h5 class="fw-bold mb-0 text-dark">E-commerce Catalog</h5>
                    <p class="text-muted small mb-0">Manage your online store inventory and availability</p>
                </div>
                <div class="d-flex gap-2">
                    <select id="filterCategory" class="form-select form-select-sm rounded-1 px-3 border-0 shadow-sm" style="width: 160px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary rounded-1 px-4 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fa-solid fa-plus me-2"></i> Add Product
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="productTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 border-0">PRODUCT DETAILS</th>
                            <th class="border-0">CATEGORY</th>
                            <th class="border-0">PRICE</th>
                            <th class="border-0">STOCK</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-4 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @include('admin.store._product_table')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Add New Store Product</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addProductForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Product Name</label>
                            <input type="text" name="name" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. First Aid Kit" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Category</label>
                            <input type="text" name="category" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. Medical Equipment">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Price (TZS)</label>
                            <input type="number" name="price" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="0" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Product Image</label>
                            <input type="file" name="image" class="form-control rounded-1 px-3 shadow-none border-light bg-light" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Description</label>
                            <textarea name="description" class="form-control rounded-1 px-3 shadow-none border-light bg-light" rows="3" placeholder="Product details..."></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light rounded-1 px-4 me-2 border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Edit Store Product</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editProductForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_product_id">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Product Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control rounded-1 px-3 shadow-none border-light bg-light" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Category</label>
                            <input type="text" name="category" id="edit_category" class="form-control rounded-1 px-3 shadow-none border-light bg-light">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Price (TZS)</label>
                            <input type="number" name="price" id="edit_price" class="form-control rounded-1 px-3 shadow-none border-light bg-light" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="edit_quantity" class="form-control rounded-1 px-3 shadow-none border-light bg-light" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Product Image (Leave blank to keep current)</label>
                            <input type="file" name="image" class="form-control rounded-1 px-3 shadow-none border-light bg-light" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Description</label>
                            <textarea name="description" id="edit_description" class="form-control rounded-1 px-3 shadow-none border-light bg-light" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light rounded-1 px-4 me-2 border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const productTable = $('#productTable').DataTable({
            responsive: true,
            dom: 'rftip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search products...",
                emptyTable: "No products found."
            }
        });

        // AJAX Filtering
        function applyFilters() {
            const category = $('#filterCategory').val();
            const search = $('.dataTables_filter input').val();

            $.ajax({
                url: "{{ route('admin.store.index') }}",
                data: { category, search },
                success: function(html) {
                    productTable.destroy();
                    $('#productTableBody').html(html);
                    $('#productTable').DataTable({
                        responsive: true,
                        dom: 'rftip',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search products...",
                            emptyTable: "No products found."
                        }
                    });
                }
            });
        }

        $('#filterCategory').on('change', applyFilters);

        // Open Edit Modal
        $(document).on('click', '.edit-product', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const category = $(this).data('category');
            const price = $(this).data('price');
            const quantity = $(this).data('quantity');
            const description = $(this).data('description');

            $('#edit_product_id').val(id);
            $('#edit_name').val(name);
            $('#edit_category').val(category);
            $('#edit_price').val(price);
            $('#edit_quantity').val(quantity);
            $('#edit_description').val(description);

            $('#editProductModal').modal('show');
        });

        // AJAX Update
        $('#editProductForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#edit_product_id').val();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Updating...').prop('disabled', true);

            const formData = new FormData(this);

            $.ajax({
                url: `{{ url('admin/store') }}/${id}`,
                method: "POST", // Form has _method PUT
                data: formData,
                processData: false,
                contentType: false,
                success: function(resp) {
                    $('#editProductModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Updated!', text: resp.message, timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                },
                error: function(xhr) {
                    $btn.html(originalText).prop('disabled', false);
                    let msg = 'Something went wrong!';
                    if (xhr.status === 422) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    Swal.fire('Error!', msg, 'error');
                }
            });
        });

        // AJAX Creation
        $('#addProductForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...').prop('disabled', true);

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.store.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(resp) {
                    $('#addProductModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success!', text: resp.message, timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                },
                error: function(xhr) {
                    $btn.html(originalText).prop('disabled', false);
                    let msg = 'Something went wrong!';
                    if (xhr.status === 422) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    Swal.fire('Error!', msg, 'error');
                }
            });
        });

        // AJAX Deletion
        $(document).on('click', '.delete-product', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to remove ${name} from catalog?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/store') }}/${id}`,
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                        success: function(resp) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: resp.message, timer: 1500, showConfirmButton: false })
                            .then(() => location.reload());
                        }
                    });
                }
            });
        });
    });
</script>

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
    .dataTables_filter input {
        border-radius: 4px !important;
        padding: 8px 20px !important;
        border: 0 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
        background: #fff !important;
        width: 250px !important;
    }
</style>
@endpush
@endsection
