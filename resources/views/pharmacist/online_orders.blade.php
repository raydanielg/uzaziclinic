@extends('layouts.app')

@section('content')
<div class="pharmacist-online-orders py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Process Online Orders</h4>
                <p class="text-muted small">Orders coming from the clinic's online shop.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Order #</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Customer</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Items</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Total</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending_orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#ORD-{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->items_count ?? 0 }} items</td>
                            <td class="fw-bold">TZS {{ number_format($order->total_price) }}</td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-primary rounded-1 px-4 fw-bold border-0">Process Order</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No pending online orders.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
