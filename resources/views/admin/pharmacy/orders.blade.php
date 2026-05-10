@extends('layouts.admin')

@section('page_title', 'Medicine Orders')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Stock Orders</h5>
                    <p class="text-muted small mb-0">Track and manage your pharmaceutical supply orders</p>
                </div>
                <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0">
                    <i class="fa-solid fa-cart-plus me-2"></i> New Order
                </button>
            </div>

            <div class="table-responsive">
                <table id="ordersTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">ORDER ID</th>
                            <th class="border-0">SUPPLIER</th>
                            <th class="border-0">ORDER DATE</th>
                            <th class="border-0">TOTAL AMOUNT</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-file-invoice-dollar text-primary"></i>
                                    </div>
                                    <span class="fw-bold text-dark text-uppercase small">ORD-2026-001</span>
                                </div>
                            </td>
                            <td>PharmaCo Ltd</td>
                            <td class="text-muted small">May 10, 2026</td>
                            <td class="fw-bold text-dark">540,000 TZS</td>
                            <td>
                                <span class="badge bg-warning-subtle text-warning border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">Pending</span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Details">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Print Invoice">
                                        <i class="fa-solid fa-print text-secondary small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
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
    .ls-1 { letter-spacing: 0.5px; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                emptyTable: "No stock orders found."
            }
        });
    });
</script>
@endpush
