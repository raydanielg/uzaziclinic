@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Invoices</h1>
                <p class="text-muted small mb-0">Manage all hospital invoices and billing records.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                    <i class="fa-solid fa-plus me-2"></i>Create Invoice
                </button>
            </div>
        </div>

        <!-- Summary -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-warning">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Pending</p>
                    <h3 class="fw-bold mb-0 text-warning">{{ $invoices->where('status','pending')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-success">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Paid</p>
                    <h3 class="fw-bold mb-0 text-success">{{ $invoices->where('status','paid')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-danger">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Overdue</p>
                    <h3 class="fw-bold mb-0 text-danger">{{ $invoices->where('status','overdue')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-primary">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Total</p>
                    <h3 class="fw-bold mb-0 text-primary">{{ $invoices->total() }}</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-invoice-dollar me-2 text-primary"></i>All Invoices</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Paid</option>
                        <option>Overdue</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" style="width:auto;">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="invoicesTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">Invoice #</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Patient</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Amount (TZS)</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Type</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Date</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Due Date</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $invoice->patient->name ?? 'N/A' }}</div>
                                    <small class="text-muted">ID: #PT-{{ $invoice->patient_id }}</small>
                                </td>
                                <td class="fw-bold">{{ number_format($invoice->total_amount ?? $invoice->amount ?? 0) }}</td>
                                <td class="small text-muted">{{ ucfirst($invoice->type ?? 'General') }}</td>
                                <td class="small text-muted">{{ $invoice->created_at->format('d M Y') }}</td>
                                <td class="small text-muted">{{ optional($invoice->due_date)->format('d M Y') ?? 'N/A' }}</td>
                                <td>
                                    @php $st = $invoice->status ?? 'pending'; @endphp
                                    <span class="badge bg-{{ $st === 'paid' ? 'success' : ($st === 'overdue' ? 'danger' : 'warning') }}-subtle 
                                        text-{{ $st === 'paid' ? 'success' : ($st === 'overdue' ? 'danger' : 'warning') }} rounded-pill">
                                        {{ ucfirst($st) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary rounded-2 me-1">View</button>
                                        <button class="btn btn-sm btn-outline-success rounded-2">Pay</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-file-invoice fs-2 d-block mb-2 opacity-25"></i>
                                    No invoices found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($invoices->hasPages())
            <div class="card-footer bg-white border-0">{{ $invoices->links() }}</div>
            @endif
        </div>
    </div>
</div>

<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Create New Invoice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Patient</label>
                        <input type="text" class="form-control" placeholder="Search patient...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Invoice Type</label>
                        <select class="form-select">
                            <option>Consultation</option>
                            <option>Laboratory</option>
                            <option>Pharmacy</option>
                            <option>Surgery</option>
                            <option>Admission</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Amount (TZS)</label>
                        <input type="number" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Due Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Description / Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Details of services rendered..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4"><i class="fa-solid fa-save me-2"></i>Create Invoice</button>
            </div>
        </div>
    </div>
</div>
@endsection
