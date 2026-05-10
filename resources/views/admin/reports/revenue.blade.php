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
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-day text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Monthly</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($monthlyRevenue ?? 0) }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-hand-holding-dollar text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pending</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($pendingPayments ?? 0) }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-wallet text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Growth</p>
                    <h4 class="fw-bold mb-0 text-dark small">+12.5%</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-1 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Payment Methods</h5>
                    <p class="text-muted small mb-0">Revenue breakdown by channel</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">CHANNEL</th>
                            <th class="border-0">TOTAL COLLECTED</th>
                            <th class="border-0">PERCENTAGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byPaymentMethod as $method)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-dark text-uppercase small ls-1">{{ $method->payment_method ?: 'Cash' }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark small">{{ number_format($method->total) }} TZS</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                        @php $perc = $totalRevenue > 0 ? ($method->total / $totalRevenue) * 100 : 0; @endphp
                                        <div class="progress-bar bg-primary" style="width: {{ $perc }}%"></div>
                                    </div>
                                    <span class="small fw-bold text-muted">{{ round($perc, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
