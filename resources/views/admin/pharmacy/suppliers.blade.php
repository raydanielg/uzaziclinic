@extends('layouts.admin')

@section('page_title', 'Medicine Suppliers')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Medicine Suppliers</h5>
                    <p class="text-muted small mb-0">Manage and contact your pharmaceutical suppliers</p>
                </div>
                <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0">
                    <i class="fa-solid fa-plus me-2"></i> Add Supplier
                </button>
            </div>

            <div class="table-responsive">
                <table id="suppliersTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">SUPPLIER NAME</th>
                            <th class="border-0">CONTACT PERSON</th>
                            <th class="border-0">PHONE</th>
                            <th class="border-0">EMAIL</th>
                            <th class="border-0">ADDRESS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-truck-field text-primary"></i>
                                    </div>
                                    <span class="fw-bold text-dark text-uppercase">PharmaCo Ltd</span>
                                </div>
                            </td>
                            <td>James Wilson</td>
                            <td>+255 712 345 678</td>
                            <td class="text-muted small">contact@pharmaco.com</td>
                            <td class="text-muted small">Dar es Salaam, TZ</td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Edit">
                                        <i class="fa-solid fa-pen text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Delete">
                                        <i class="fa-solid fa-trash text-danger small"></i>
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
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#suppliersTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                emptyTable: "No suppliers registered yet."
            }
        });
    });
</script>
@endpush
