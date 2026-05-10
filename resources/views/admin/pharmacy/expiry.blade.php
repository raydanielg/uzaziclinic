@extends('layouts.admin')

@section('page_title', 'Expiry Tracker')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Medicine Expiry Tracker</h5>
                    <p class="text-muted small mb-0">Monitor products near their expiration date to manage waste</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pharmacy.stock') }}" class="btn btn-light rounded-1 px-4 shadow-sm border">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Inventory
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="expiryTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">MEDICINE NAME</th>
                            <th class="border-0">CATEGORY</th>
                            <th class="border-0">QUANTITY</th>
                            <th class="border-0">EXPIRY DATE</th>
                            <th class="border-0">TIME REMAINING</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiring ?? [] as $medicine)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-hourglass-half {{ $medicine->isExpired() ? 'text-danger' : 'text-warning' }}"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $medicine->name }}</span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border fw-normal">{{ $medicine->category }}</span></td>
                            <td class="fw-bold text-dark">{{ $medicine->quantity }} Units</td>
                            <td>
                                <span class="{{ $medicine->isExpired() ? 'text-danger fw-bold' : 'text-muted small' }}">
                                    {{ $medicine->expiry_date?->format('d M, Y') ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($medicine->expiry_date)
                                    @if($medicine->isExpired())
                                        <span class="text-danger small fw-bold">Expired {{ $medicine->expiry_date->diffForHumans() }}</span>
                                    @else
                                        <span class="text-dark small">Expires in {{ now()->diffInDays($medicine->expiry_date) }} days</span>
                                    @endif
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $medicine->status_badge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $medicine->status_label }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-medicine" 
                                            data-id="{{ $medicine->id }}" 
                                            data-name="{{ $medicine->name }}"
                                            title="Remove Expired">
                                        <i class="fa-solid fa-trash text-danger small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-shield-check text-success fs-1 mb-2 d-block"></i>
                                No medicines are expiring soon.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $expiring->links() ?? '' }}
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
        $('#expiryTable').DataTable({
            responsive: true,
            dom: 'rtip',
            order: [[3, 'asc']],
            language: {
                emptyTable: "No expiry alerts found."
            }
        });
    });
</script>
@endpush
