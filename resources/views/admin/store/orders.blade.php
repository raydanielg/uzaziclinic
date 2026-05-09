@extends('layouts.admin')

@section('page_title', 'Customer Orders')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Orodha ya Oda (Customer Orders)</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Shop</a></li>
                    <li class="breadcrumb-item active">Orders</li>
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
                            <th class="ps-4">Order ID</th>
                            <th>Mteja</th>
                            <th>Tarehe</th>
                            <th>Jumla (TZS)</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="fw-bold">{{ $order->user->name ?? 'Mteja Asiyejulikana' }}</div>
                                <small class="text-muted">{{ $order->user->phone ?? '' }}</small>
                            </td>
                            <td>{{ $order->created_at->format('d M, Y h:i A') }}</td>
                            <td class="fw-bold">{{ number_format($order->total_amount, 0) }}/=</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning-soft text-warning',
                                        'processing' => 'bg-info-soft text-info',
                                        'completed' => 'bg-success-soft text-success',
                                        'cancelled' => 'bg-danger-soft text-danger',
                                    ][$order->status] ?? 'bg-secondary-soft text-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border shadow-none"><i class="fas fa-eye me-1"></i>Angalia</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-shopping-basket fa-3x mb-3 opacity-20"></i>
                                    <p class="mb-0">Hakuna oda iliyopatikana kwa sasa.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection
