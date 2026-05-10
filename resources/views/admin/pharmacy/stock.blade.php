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

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="addMedicineModalLabel">Add New Medicine</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addMedicineForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Medicine Name</label>
                            <input type="text" name="name" class="form-control rounded-pill px-3 shadow-none border-light bg-light" placeholder="e.g. Paracetamol" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Category</label>
                            <select name="category" class="form-select rounded-pill px-3 shadow-none border-light bg-light" required>
                                <option value="">Select Category</option>
                                <option value="Antibiotics">Antibiotics</option>
                                <option value="Painkillers">Painkillers</option>
                                <option value="Antipyretics">Antipyretics</option>
                                <option value="Antifungals">Antifungals</option>
                                <option value="Supplements">Supplements</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Quantity (Units)</label>
                            <input type="number" name="quantity" class="form-control rounded-pill px-3 shadow-none border-light bg-light" placeholder="e.g. 100" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Price per Unit</label>
                            <input type="number" step="0.01" name="price" class="form-control rounded-pill px-3 shadow-none border-light bg-light" placeholder="e.g. 500.00" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control rounded-pill px-3 shadow-none border-light bg-light" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Description (Optional)</label>
                            <textarea name="description" class="form-control rounded-4 px-3 shadow-none border-light bg-light" rows="3" placeholder="Additional details..."></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4 me-2 border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Save Medicine
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

        // Add Medicine AJAX
        $('#addMedicineForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.pharmacy.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(resp) {
                    $('#addMedicineModal').modal('hide');
                    $('#addMedicineForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Medicine added successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Refresh to update stats and table
                    });
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
