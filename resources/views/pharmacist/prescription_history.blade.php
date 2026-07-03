@extends('layouts.app')

@section('content')
<div class="pharmacist-history py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Prescription History</h4>
                <p class="text-muted small">All processed prescriptions (dispensed and cancelled).</p>
            </div>
            <a href="{{ route('pharmacist.dispense.index') }}" class="btn btn-primary rounded-1 px-4 fw-bold border-0 shadow-sm">
                <i class="fa-solid fa-pills me-2"></i>Back to Dispensing
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success-subtle text-success rounded-3 p-3">
                            <i class="fa-solid fa-check fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Dispensed</div>
                            <div class="fw-bold fs-5">{{ $history->where('status', App\Models\Prescription::STATUS_DISPENSED)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger-subtle text-danger rounded-3 p-3">
                            <i class="fa-solid fa-xmark fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Cancelled</div>
                            <div class="fw-bold fs-5">{{ $history->where('status', App\Models\Prescription::STATUS_CANCELLED)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3">
                            <i class="fa-solid fa-money-bill fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Revenue</div>
                            <div class="fw-bold fs-5">TZS {{ number_format($history->where('status', App\Models\Prescription::STATUS_DISPENSED)->sum('total_cost'), 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="historyTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Items</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Dispensed By</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Total Cost</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                        <tr>
                            <td class="ps-4 small">
                                <div class="fw-bold text-dark">{{ $item->dispensed_at?->format('M d, Y') ?? $item->updated_at->format('M d, Y') }}</div>
                                <div class="text-muted" style="font-size: 0.7rem">{{ $item->dispensed_at?->format('H:i A') ?? $item->updated_at->format('H:i A') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->patient->display_name ?? 'N/A' }}</div>
                                <div class="small text-muted">{{ $item->patient->patient_number ?? '' }}</div>
                            </td>
                            <td class="small">Dr. {{ $item->doctor->display_name ?? 'N/A' }}</td>
                            <td class="small"><span class="badge bg-light text-dark border rounded-1">{{ $item->items->count() }} items</span></td>
                            <td class="small">{{ $item->pharmacist->name ?? 'N/A' }}</td>
                            <td class="fw-bold small">TZS {{ number_format($item->total_cost ?? 0, 0) }}</td>
                            <td>
                                @if($item->status === App\Models\Prescription::STATUS_DISPENSED)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Dispensed</span>
                                @elseif($item->status === App\Models\Prescription::STATUS_CANCELLED)
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1 border-0 view-items" type="button" data-bs-toggle="modal" data-bs-target="#rxModal{{ $item->id }}">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($history as $item)
<div class="modal fade" id="rxModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Prescription #RX-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase">Patient</div>
                        <div class="fw-bold">{{ $item->patient->display_name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase">Doctor</div>
                        <div class="fw-bold">Dr. {{ $item->doctor->display_name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase">Status</div>
                        <div class="fw-bold">{{ ucfirst($item->status) }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase">Total Cost</div>
                        <div class="fw-bold">TZS {{ number_format($item->total_cost ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle border-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="small text-uppercase fw-bold text-muted">Medicine</th>
                                <th class="small text-uppercase fw-bold text-muted">Qty</th>
                                <th class="small text-uppercase fw-bold text-muted">Dosage</th>
                                <th class="small text-uppercase fw-bold text-muted">Duration</th>
                                <th class="small text-uppercase fw-bold text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->items as $line)
                            <tr>
                                <td class="fw-bold small">{{ $line->medicine_name }}</td>
                                <td class="small">{{ $line->quantity }}</td>
                                <td class="small">{{ $line->dosage }}</td>
                                <td class="small">{{ $line->duration }}</td>
                                <td class="small">
                                    @if($line->dispensed)
                                        <span class="badge bg-success-subtle text-success rounded-1">Dispensed</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-1">Not dispensed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
$(document).ready(function() {
    $('#historyTable').DataTable({
        pageLength: 15,
        order: [[0, 'desc']],
        language: {
            search: "",
            searchPlaceholder: "Search history...",
            emptyTable: "No processed prescriptions found.",
            zeroRecords: "No matching prescriptions found."
        }
    });
});
</script>
@endpush
@endsection
