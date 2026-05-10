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
                <a href="{{ route('admin.pharmacy.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i> Add Medicine
                </a>
            </div>
            
            <div class="table-responsive">
                <table id="stockTable" class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="ps-3">MEDICINE NAME</th>
                            <th>CATEGORY</th>
                            <th>QUANTITY</th>
                            <th>EXPIRY DATE</th>
                            <th>STATUS</th>
                            <th class="text-end pe-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines ?? [] as $medicine)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-capsules"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $medicine->name }}</span>
                                </div>
                            </td>
                            <td>{{ $medicine->category }}</td>
                            <td>
                                <span class="fw-bold {{ $medicine->quantity <= 10 ? 'text-danger' : 'text-dark' }}">
                                    {{ $medicine->quantity }} Units
                                </span>
                            </td>
                            <td class="text-muted small">{{ $medicine->expiry_date?->format('d M, Y') ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $medicine->status_badge }} border px-2 py-1 fw-bold text-uppercase" style="font-size: 0.65rem;">
                                    {{ $medicine->status_label }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-light rounded-circle shadow-none me-1" title="Edit">
                                        <i class="fa-solid fa-pen text-primary"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light rounded-circle shadow-none delete-medicine" 
                                            data-id="{{ $medicine->id }}" 
                                            data-name="{{ $medicine->name }}"
                                            title="Delete">
                                        <i class="fa-solid fa-trash text-danger"></i>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search stock...",
                lengthMenu: "Show _MENU_ entries"
            }
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
    .avatar-sm { background-color: #f1f5f9; }
    .table thead th {
        font-size: 0.75rem !important;
        letter-spacing: 0.5px;
        background: #f8fafc !important;
        color: #64748b !important;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .transition { transition: all 0.3s ease; }
</style>
@endpush
