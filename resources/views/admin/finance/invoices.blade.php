@extends('layouts.admin')

@section('page_title', 'Billing & Finance')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-money-bill-wave text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Revenue</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_revenue'] ?? 0) }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clock-rotate-left text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pending Amount</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['pending_amount'] ?? 0) }} TZS</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-file-circle-check text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Paid Invoices</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['paid_invoices'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-secondary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-file-invoice text-secondary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Invoices</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total_invoices'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Invoices Registry</h5>
                    <p class="text-muted small mb-0">Manage billing and patient invoices</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0">
                        <i class="fa-solid fa-plus me-2"></i> Create Invoice
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="financeTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">INVOICE ID / DATE</th>
                            <th class="border-0">PATIENT / USER</th>
                            <th class="border-0">ORDER REF</th>
                            <th class="border-0">AMOUNT</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-file-invoice text-primary opacity-75 small"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-uppercase small ls-1">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $invoice->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $invoice->user->name ?? 'System User' }}</div>
                                <div class="text-muted extra-small">{{ $invoice->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border-0 px-2 py-1 small fw-normal">
                                    #ORD-{{ str_pad($invoice->order_id ?? 0, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ number_format($invoice->total_amount) }} TZS</div>
                            </td>
                            <td>
                                @php
                                    $statusBadge = [
                                        'paid' => 'bg-success-subtle text-success',
                                        'pending' => 'bg-warning-subtle text-warning',
                                        'cancelled' => 'bg-danger-subtle text-danger',
                                    ][$invoice->status] ?? 'bg-light text-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Detail">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Download PDF">
                                        <i class="fa-solid fa-file-pdf text-danger small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $invoices->links() }}
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
    .extra-small { font-size: 0.65rem; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#financeTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search invoices...",
                emptyTable: "No invoices found."
            }
        });
    });
</script>
@endpush
