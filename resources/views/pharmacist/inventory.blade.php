@extends('layouts.app')

@section('content')
<div class="pharmacist-inventory py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Medicine Inventory</h4>
                <p class="text-muted small">Manage your pharmacy stock and medicine records.</p>
            </div>
            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0 fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add Medicine
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="inventoryTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Medicine Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Category</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Stock Level</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Price</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Expiry Date</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicines as $med)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $med->name }}</div>
                                <div class="small text-muted">{{ $med->sku }}</div>
                            </td>
                            <td><span class="badge bg-light text-dark border rounded-pill px-3">{{ $med->category }}</span></td>
                            <td>
                                <div class="fw-bold {{ $med->quantity <= 10 ? 'text-danger' : 'text-dark' }}">
                                    {{ $med->quantity }} {{ $med->unit ?? 'pcs' }}
                                </div>
                                @if($med->quantity <= 10)
                                    <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.6rem;">Low Stock</span>
                                @endif
                            </td>
                            <td class="small fw-bold">TZS {{ number_format($med->price) }}</td>
                            <td class="small {{ \Carbon\Carbon::parse($med->expiry_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ \Carbon\Carbon::parse($med->expiry_date)->format('M d, Y') }}
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-edit text-primary"></i></button>
                                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-trash text-danger"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#inventoryTable').DataTable({
        paging: false,
        language: { search: "", searchPlaceholder: "Search inventory..." }
    });
});
</script>
@endpush
@endsection
