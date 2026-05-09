@extends('layouts.admin')

@section('page_title', 'Revenue Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-dollar-sign text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Revenue</p>
                    <h4 class="fw-bold mb-0">${{ number_format($totalRevenue ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-chart-line text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">This Month</p>
                    <h4 class="fw-bold mb-0">${{ number_format($monthlyRevenue ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clock text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Pending</p>
                    <h4 class="fw-bold mb-0">${{ number_format($pendingPayments ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-credit-card text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Payment Methods</p>
                    <h4 class="fw-bold mb-0">{{ $byPaymentMethod->count() ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Revenue by Payment Method</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Method</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byPaymentMethod ?? [] as $row)
                        <tr>
                            <td><span class="fw-bold">{{ ucfirst($row->payment_method ?? 'Unknown') }}</span></td>
                            <td>${{ number_format($row->total, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">No payment data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.finance.invoices') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-file-invoice me-2"></i> View Invoices
                </a>
                <a href="{{ route('admin.finance.receipts') }}" class="btn btn-outline-success">
                    <i class="fa-solid fa-receipt me-2"></i> View Receipts
                </a>
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
