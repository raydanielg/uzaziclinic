@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="admin-dashboard py-4">
    <div class="container-fluid">
        
        {{-- Header --}}
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Payment Management</h1>
                <p class="text-muted small mb-0">Manage and confirm patient payments</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-success rounded-2" onclick="loadPendingPayments()">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>Pending Payments
                </button>
            </div>
        </div>

        {{-- Payments Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-blue"></i>All Payments</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Patient</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar bg-blue-soft text-blue">
                                            {{ strtoupper(substr($payment->patient->name ?? 'N/A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">{{ $payment->patient->name ?? 'N/A' }}</div>
                                            <div class="text-muted" style="font-size:.7rem">#PT-{{ $payment->patient_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">{{ $payment->service_name ?? 'N/A' }}</td>
                                <td class="small fw-semibold">TSh {{ number_format($payment->amount) }}</td>
                                <td>
                                    @if($payment->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $payment->created_at->format('d M Y') }}</td>
                                <td class="text-end pe-3">
                                    @if($payment->status === 'pending')
                                        <button class="btn btn-sm btn-success" onclick="confirmPayment({{ $payment->id }}, {{ $payment->amount }}, '{{ $payment->patient->name ?? 'Patient' }}')">
                                            <i class="fa-solid fa-check"></i> Confirm
                                        </button>
                                    @else
                                        <span class="text-muted small"><i class="fa-solid fa-check-double"></i> Confirmed</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-money-bill-wave fs-2 opacity-25 d-block mb-2"></i>
                                    No payments found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($payments->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Load pending payments
function loadPendingPayments() {
    fetch('/admin/payments/pending', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.payments.length > 0) {
            let html = '<div class="list-group">';
            data.payments.forEach(payment => {
                html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">${payment.patient.name} (PT-${payment.patient.id})</div>
                            <small class="text-muted">${payment.service_name} - TSh ${payment.amount.toLocaleString()}</small>
                        </div>
                        <button class="btn btn-sm btn-success" onclick="confirmPayment(${payment.id}, ${payment.amount}, '${payment.patient.name}')">
                            <i class="fa-solid fa-check"></i> Confirm
                        </button>
                    </div>
                `;
            });
            html += '</div>';
            
            Swal.fire({
                title: 'Pending Payments',
                html: html,
                width: '600px',
                showConfirmButton: false
            });
        } else {
            Swal.fire('Info', 'No pending payments', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Failed to load payments', 'error');
    });
}

// Confirm payment
function confirmPayment(paymentId, amount, patientName) {
    Swal.fire({
        title: 'Confirm Payment',
        text: `Confirm payment of TSh ${amount.toLocaleString()} from ${patientName}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/payments/${paymentId}/confirm`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    method: 'bank_transfer',
                    reference: 'ADMIN_CONFIRM'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Confirmed',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to confirm payment', 'error');
            });
        }
    });
}
</script>
@endpush
@endsection
