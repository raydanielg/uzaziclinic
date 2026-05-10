@extends('layouts.admin')

@section('page_title', 'Customer Orders')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Customer Orders</h5>
                    <p class="text-muted small mb-0">Track and manage store purchases from patients</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.store.index') }}" class="btn btn-light rounded-1 px-4 shadow-sm border small">
                        <i class="fa-solid fa-boxes-stacked me-2"></i> Product Catalog
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="ordersTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 border-0">ORDER ID / DATE</th>
                            <th class="border-0">CUSTOMER</th>
                            <th class="border-0">AMOUNT</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-4 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-shopping-cart small"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block small text-uppercase ls-1">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $order->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->user->name ?? 'Unknown Customer' }}</div>
                                <div class="text-muted extra-small">{{ $order->user->phone ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark small">{{ number_format($order->total_amount, 0) }} TZS</div>
                            </td>
                            <td>
                                @php
                                    $statusBadge = [
                                        'pending' => 'bg-warning-subtle text-warning',
                                        'processing' => 'bg-info-subtle text-info',
                                        'completed' => 'bg-success-subtle text-success',
                                        'cancelled' => 'bg-danger-subtle text-danger',
                                    ][$order->status] ?? 'bg-light text-dark';
                                @endphp
                                <span class="badge {{ $statusBadge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Details">
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
                {{ $orders->links() }}
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
        $('#ordersTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search orders...",
                emptyTable: "No orders found."
            }
        });
    });
</script>
@endpush
