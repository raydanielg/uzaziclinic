@extends('layouts.app')

@section('content')
<div class="pharmacist-orders py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Medicine Orders</h4>
                <p class="text-muted small">Manage and track medicine procurement orders.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Order ID</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Supplier</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#ORD-{{ $order->id }}</td>
                            <td>{{ $order->supplier->name ?? 'General Supplier' }}</td>
                            <td class="small">{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}-subtle text-{{ $order->status == 'pending' ? 'warning' : 'success' }} rounded-pill px-3">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-eye text-primary"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
