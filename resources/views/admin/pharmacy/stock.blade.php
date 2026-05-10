@extends('layouts.admin')

@section('page_title', 'Pharmacy Stock Management')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-pills text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Medicines</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total'] ?? 0 }}</h4>
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
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['low_stock'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-danger-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-xmark text-danger fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Expired Products</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['expired'] ?? 0 }}</h4>
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
                    <h5 class="fw-bold mb-0 text-dark">Medicines Inventory</h5>
                    <p class="text-muted small mb-0">Monitor and manage your pharmaceutical stock levels</p>
                </div>
                <div class="d-flex gap-2">
                    <select id="filterCategory" class="form-select form-select-sm rounded-pill px-3 border-0 shadow-sm" style="width: 150px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                    <select id="filterStatus" class="form-select form-select-sm rounded-pill px-3 border-0 shadow-sm" style="width: 150px;">
                        <option value="">All Status</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="expired">Expired</option>
                    </select>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                        <i class="fa-solid fa-plus me-2"></i> Add Medicine
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="stockTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">MEDICINE NAME</th>
                            <th class="border-0">CATEGORY</th>
                            <th class="border-0">QUANTITY</th>
                            <th class="border-0">EXPIRY DATE</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="stockTableBody">
                        @if(count($medicines) > 0)
                            @include('admin.pharmacy._stock_table')
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const stockTable = $('#stockTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
            dom: 'rftip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search stock...",
                emptyTable: "No medicines found matching your filters."
            }
        });

        // AJAX Filter Function
        function applyFilters() {
            const category = $('#filterCategory').val();
            const status = $('#filterStatus').val();

            $.ajax({
                url: "{{ route('admin.pharmacy.stock') }}",
                data: { category, status },
                success: function(html) {
                    stockTable.destroy();
                    $('#stockTableBody').html(html);
                    $('#stockTable').DataTable({
                        responsive: true,
                        order: [[0, 'asc']],
                        dom: 'rftip',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search stock...",
                        }
                    });
                }
            });
        }

        $('#filterCategory, #filterStatus').on('change', applyFilters);

        $(document).on('click', '.delete-medicine', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to remove ${name} from stock?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/pharmacy/stock') }}/${id}`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(resp) {
                            if(resp.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: resp.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
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
    .form-select-sm { font-size: 0.75rem; height: 38px; }
    .dataTables_filter input {
        border-radius: 50px !important;
        padding: 8px 20px !important;
        border: 0 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
        background: #fff !important;
        width: 250px !important;
    }
    .dataTables_info, .dataTables_paginate { font-size: 0.8rem; margin-top: 15px; }
</style>
@endpush
