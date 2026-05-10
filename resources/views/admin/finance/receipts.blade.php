@extends('layouts.admin')

@section('page_title', 'Receipts & Invoices')

@section('content')
<div class="container-fluid py-4">

            <div class="table-responsive">
                <table id="receiptsTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">RECEIPT ID / DATE</th>
                            <th class="border-0">PATIENT / CUSTOMER</th>
                            <th class="border-0">INVOICE REF</th>
                            <th class="border-0">PAID AMOUNT</th>
                            <th class="border-0">METHOD</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receipts as $receipt)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success-subtle text-success rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-receipt small"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-uppercase small ls-1">#REC-{{ str_pad($receipt->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $receipt->updated_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $receipt->user->name ?? 'System User' }}</div>
                                <div class="text-muted extra-small">{{ $receipt->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border-0 px-2 py-1 small fw-normal">
                                    #INV-{{ str_pad($receipt->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-success small">{{ number_format($receipt->total_amount) }} TZS</div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    Online
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Receipt">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Print Receipt">
                                        <i class="fa-solid fa-print text-secondary small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
