@extends('layouts.app')

@section('content')
<div class="accountant-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Accountant Dashboard</h1>
                <p class="text-muted small">Welcome, {{ Auth::user()->name }}. Manage hospital finances and invoices.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-money-bill-trend-up fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Total Revenue</h6>
                            <h3 class="mb-0 fw-bold">TZS {{ number_format($stats['total_revenue']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-file-invoice-dollar fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Pending Invoices</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_invoices'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-primary border-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-hand-holding-dollar fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Today's Collection</h6>
                            <h3 class="mb-0 fw-bold">TZS {{ number_format($stats['today_payments']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3">
                            <i class="fa-solid fa-receipt fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Total Invoices</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_invoices'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Recent Payments</h5>
                        <a href="{{ route('accountant.payments') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3 border-0">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Invoice #</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Amount</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_payments as $payment)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">#INV-{{ $payment->invoice_id }}</td>
                                        <td>{{ $payment->invoice->patient->name ?? 'N/A' }}</td>
                                        <td class="fw-bold text-success">TZS {{ number_format($payment->amount) }}</td>
                                        <td class="text-end pe-4 small text-muted">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No recent payments.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="bg-success p-4 text-white">
                        <h6 class="small text-uppercase opacity-75 fw-bold mb-3">Finance Summary</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">TZS {{ number_format($stats['today_payments']) }}</h3>
                                <p class="small mb-0 opacity-75">Today's Collection</p>
                            </div>
                            <i class="fa-solid fa-sack-dollar fs-1 opacity-25"></i>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('accountant.invoices') }}" class="btn btn-warning rounded-1 py-2 text-start ps-3 border-0 fw-bold">
                                <i class="fa-solid fa-file-invoice me-2"></i> Manage Invoices
                            </a>
                            <a href="{{ route('accountant.payments') }}" class="btn btn-success rounded-1 py-2 text-start ps-3 border-0 fw-bold text-white">
                                <i class="fa-solid fa-money-bill-wave me-2"></i> View Payments
                            </a>
                            <a href="{{ route('accountant.reports') }}" class="btn btn-outline-secondary rounded-1 py-2 text-start ps-3 border-0">
                                <i class="fa-solid fa-chart-bar me-2"></i> Financial Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pending invoices alert -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase">Pending Invoices</h6>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="small text-muted">Total Pending</span>
                        <span class="badge bg-warning-subtle text-warning fw-bold fs-6">{{ $stats['pending_invoices'] }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2">
                        <span class="small text-muted">Total Invoices</span>
                        <span class="badge bg-primary-subtle text-primary fw-bold fs-6">{{ $stats['total_invoices'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endsection
