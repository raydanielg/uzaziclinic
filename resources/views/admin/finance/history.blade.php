@extends('layouts.admin')

@section('page_title', 'Payment History')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Payment History (Historia ya Malipo)</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payment History</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6 class="small text-uppercase mb-2 opacity-75">Leo</h6>
                    <h3 class="mb-0 fw-bold">TSh 1,250,000</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6 class="small text-uppercase mb-2 opacity-75">Mwezi Huu</h6>
                    <h3 class="mb-0 fw-bold">TSh 12,400,000</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tarehe</th>
                            <th>Mteja</th>
                            <th>Method</th>
                            <th>Kiasi</th>
                            <th>Hali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                        <tr>
                            <td class="ps-4">{{ $inv->created_at->format('d M, Y H:i') }}</td>
                            <td>{{ $inv->user->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">Cash/M-Pesa</span></td>
                            <td class="fw-bold text-success">{{ number_format($inv->amount, 0) }}/=</td>
                            <td><span class="badge bg-success-soft text-success">Kamilifu</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Hakuna historia ya malipo.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
