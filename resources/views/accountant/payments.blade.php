@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Payments</h1>
                <p class="text-muted small mb-0">All received payment transactions.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary rounded-2 me-2" onclick="window.print()">
                    <i class="fa-solid fa-print me-2"></i>Print
                </button>
                <button class="btn btn-primary rounded-2">
                    <i class="fa-solid fa-plus me-2"></i>Record Payment
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-money-bill-wave me-2 text-success"></i>Payment History</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>All Methods</option>
                        <option>Cash</option>
                        <option>Card</option>
                        <option>Mobile Money</option>
                        <option>Insurance</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" style="width:auto;">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="paymentsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">#</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Invoice Ref</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Patient</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Amount (TZS)</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Method</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Reference</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Date & Time</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                <td class="fw-bold text-primary">#INV-{{ $payment->invoice_id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $payment->invoice->patient->name ?? 'N/A' }}</div>
                                </td>
                                <td class="fw-bold text-success">{{ number_format($payment->amount) }}</td>
                                <td>
                                    @php $method = $payment->payment_method ?? 'cash'; @endphp
                                    <span class="badge bg-light text-dark border rounded-pill">{{ ucfirst($method) }}</span>
                                </td>
                                <td class="small text-muted">{{ $payment->reference ?? 'N/A' }}</td>
                                <td class="small text-muted">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-secondary rounded-2">Receipt</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-receipt fs-2 d-block mb-2 opacity-25"></i>
                                    No payment records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($payments->hasPages())
            <div class="card-footer bg-white border-0">{{ $payments->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
