@extends('layouts.admin')

@section('page_title', 'Payment History')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Transaction History</h5>
                    <p class="text-muted small mb-0">Complete record of all financial transactions</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light rounded-1 px-3 border shadow-sm small">
                        <i class="fa-solid fa-download me-2"></i> Export
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="paymentsTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">TRANSACTION ID / DATE</th>
                            <th class="border-0">USER / CUSTOMER</th>
                            <th class="border-0">REFERENCE</th>
                            <th class="border-0">AMOUNT</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-info-subtle text-info rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-credit-card small"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-uppercase small ls-1">#TRX-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $payment->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $payment->user->name ?? 'System User' }}</div>
                                <div class="text-muted extra-small">{{ $payment->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border-0 px-2 py-1 small fw-normal">
                                    #INV-{{ str_pad($payment->invoice_id ?? 0, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ number_format($payment->amount) }} TZS</div>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $payment->status ?? 'Completed' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Detail">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $payments->links() }}
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
        $('#paymentsTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search transactions...",
                emptyTable: "No transactions found."
            }
        });
    });
</script>
@endpush
