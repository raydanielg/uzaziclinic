@extends('layouts.admin')

@section('page_title', 'Receipts & Invoices')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Receipts & Invoices (Malipo na Ankara)</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Finance</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Invoice ID</th>
                            <th>Mteja / Mgonjwa</th>
                            <th>Tarehe</th>
                            <th>Kiasi (TZS)</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td class="ps-4 fw-bold">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $invoice->user->name ?? ($invoice->order->user->name ?? 'N/A') }}</td>
                            <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                            <td class="fw-bold">{{ number_format($invoice->amount, 0) }}/=</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}-soft text-{{ $invoice->status == 'paid' ? 'success' : 'warning' }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border"><i class="fas fa-print me-1 text-primary"></i>Ankara</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-20"></i>
                                <p class="mb-0">Hakuna ankara (invoices) zilizopatikana.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
