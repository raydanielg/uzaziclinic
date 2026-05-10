@extends('layouts.app')

@section('content')
<div class="pharmacist-history py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Prescription History</h4>
                <p class="text-muted small">View all dispensed and historical prescriptions.</p>
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
                            <th class="small text-uppercase fw-bold text-muted border-0">Total Amount</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $item)
                        <tr>
                            <td class="ps-4 small text-muted">{{ $item->updated_at->format('M d, Y H:i') }}</td>
                            <td><span class="fw-bold">{{ $item->patient->name ?? 'N/A' }}</span></td>
                            <td class="small">Dr. {{ $item->doctor->name ?? 'N/A' }}</td>
                            <td class="fw-bold">TZS {{ number_format($item->total_price ?? 0) }}</td>
                            <td class="text-end pe-4">
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">Dispensed</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#historyTable').DataTable();
});
</script>
@endpush
@endsection
