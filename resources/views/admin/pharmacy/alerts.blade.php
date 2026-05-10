@extends('layouts.admin')

@section('page_title', 'Stock Alerts')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Stock Alerts</h5>
                    <p class="text-muted small mb-0">Medicines that are low in stock or near expiry date</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pharmacy.stock') }}" class="btn btn-light rounded-1 px-4 shadow-sm border">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Inventory
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="alertsTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">MEDICINE NAME</th>
                            <th class="border-0">CATEGORY</th>
                            <th class="border-0">QUANTITY</th>
                            <th class="border-0">EXPIRY DATE</th>
                            <th class="border-0">ALERT TYPE</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alerts ?? [] as $medicine)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $medicine->name }}</span>
                                </div>
                            </td>
                            <td>{{ $medicine->category }}</td>
                            <td>
                                <span class="fw-bold {{ $medicine->quantity <= 10 ? 'text-danger' : 'text-dark' }}">
                                    {{ $medicine->quantity }} Units
                                </span>
                            </td>
                            <td class="text-muted small">{{ $medicine->expiry_date?->format('d M, Y') ?? 'N/A' }}</td>
                            <td>
                                @if($medicine->isExpired())
                                    <span class="badge bg-danger-subtle text-danger border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">Expired</span>
                                @elseif($medicine->expiry_date && $medicine->expiry_date->diffInMonths(now()) < 3)
                                    <span class="badge bg-warning-subtle text-warning border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">Near Expiry</span>
                                @endif
                                
                                @if($medicine->isLowStock())
                                    <span class="badge bg-info-subtle text-info border-0 px-2 py-1 fw-bold text-uppercase ls-1 ms-1" style="font-size: 0.6rem;">Low Stock</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <a href="{{ route('admin.pharmacy.create') }}" class="btn btn-sm btn-white border-0 py-1 px-3" title="Restock">
                                        <i class="fa-solid fa-plus text-success small"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-check-circle text-success fs-1 mb-2 d-block"></i>
                                No critical alerts at the moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    .ls-1 { letter-spacing: 0.5px; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#alertsTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                emptyTable: "No critical alerts found."
            }
        });
    });
</script>
@endpush
