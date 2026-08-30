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
                                    <div class="d-flex gap-1 justify-content-end">
                                        @if($payment->status === 'pending')
                                            <button class="btn btn-sm btn-success" onclick="confirmPayment({{ $payment->id }}, {{ $payment->amount }}, '{{ $payment->patient->name ?? 'Patient' }}')">
                                                <i class="fa-solid fa-check"></i> Confirm
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-primary rounded-2" onclick="editPayment({{ $payment->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </div>
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

<!-- Edit Payment Modal -->
<div class="modal fade" id="editPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Payment</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="editPaymentId">

                <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="user-avatar bg-primary text-white">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold" id="editPatientName">-</div>
                        <div class="text-muted small" id="editPatientId">-</div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Amount (TZS) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">TZS</span>
                            <input type="number" id="editAmount" class="form-control fw-bold" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Service Name</label>
                        <input type="text" id="editServiceName" class="form-control" placeholder="e.g. Consultation, Lab Tests">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Payment Method <span class="text-danger">*</span></label>
                        <select id="editMethod" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="mobile">Mobile Money</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Status <span class="text-danger">*</span></label>
                        <select id="editStatus" class="form-select" required>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Reference / Receipt No.</label>
                        <input type="text" id="editReference" class="form-control" placeholder="e.g. 2026-0045">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light rounded-2" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-2 px-4" id="savePaymentBtn">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Edit payment - load data
function editPayment(paymentId) {
    fetch('/admin/payments/' + paymentId + '/edit', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const p = data.payment;
            document.getElementById('editPaymentId').value = p.id;
            document.getElementById('editPatientName').textContent = p.patient_name;
            document.getElementById('editPatientId').textContent = '#PT-' + p.patient_id;
            document.getElementById('editAmount').value = p.amount;
            document.getElementById('editServiceName').value = p.service_name;
            document.getElementById('editMethod').value = p.method;
            document.getElementById('editStatus').value = p.status;
            document.getElementById('editReference').value = p.reference;
            new bootstrap.Modal(document.getElementById('editPaymentModal')).show();
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Failed to load payment data', 'error');
    });
}

// Save payment changes
document.getElementById('savePaymentBtn').addEventListener('click', function() {
    const paymentId = document.getElementById('editPaymentId').value;
    const amount = document.getElementById('editAmount').value;
    const serviceName = document.getElementById('editServiceName').value;
    const method = document.getElementById('editMethod').value;
    const status = document.getElementById('editStatus').value;
    const reference = document.getElementById('editReference').value;

    if (!amount || parseFloat(amount) < 0) {
        return Swal.fire('Error', 'Please enter a valid amount', 'warning');
    }

    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...';

    fetch('/admin/payments/' + paymentId + '/update', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            amount: amount,
            service_name: serviceName,
            method: method,
            status: status,
            reference: reference
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editPaymentModal')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Failed to update payment', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>Save Changes';
    });
});

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
