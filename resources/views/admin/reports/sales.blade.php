@extends('layouts.admin')

@section('page_title', 'Sales Report')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-cart-shopping text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Sales (Monthly)</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalSales ?? 0) }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-file-invoice-dollar text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Orders</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalOrders ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-chart-line text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Avg. Order Value</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalOrders > 0 ? number_format($totalSales / $totalOrders) : 0 }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Sales Trends & Records</h5>
                    <p class="text-muted small mb-0">Daily sales performance overview</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light rounded-1 px-3 border shadow-sm small">
                        <i class="fa-solid fa-download me-2"></i> Export CSV
                    </button>
                    <button class="btn btn-primary rounded-1 px-3 shadow-sm border-0 small">
                        <i class="fa-solid fa-print me-2"></i> Print Report
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="salesTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">DATE</th>
                            <th class="border-0">TOTAL REVENUE</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesData as $data)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark small">{{ date('M d, Y', strtotime($data->date)) }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ number_format($data->total) }} TZS</div>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    Completed
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Details">
                                    <i class="fa-solid fa-eye text-primary small"></i>
                                </button>
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
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#salesTable').DataTable({
            responsive: true,
            dom: 'rtip',
            order: [[0, 'desc']]
        });
    });
</script>
@endpush
