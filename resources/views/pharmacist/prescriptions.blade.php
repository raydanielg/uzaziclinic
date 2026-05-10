@extends('layouts.app')

@section('content')
<div class="pharmacist-prescriptions py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Pending Prescriptions</h4>
                <p class="text-muted small">Select a prescription to dispense medicines to patients.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="prescriptionsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Items</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $p->created_at->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ $p->created_at->format('H:i A') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->patient->name ?? 'N/A' }}</div>
                                <div class="small text-muted">ID: #PT-{{ $p->patient_id }}</div>
                            </td>
                            <td><span class="small fw-bold text-primary">Dr. {{ $p->doctor->name ?? 'N/A' }}</span></td>
                            <td><span class="badge bg-info-subtle text-info rounded-1 px-3">View Items</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('pharmacist.prescriptions.dispense', $p->id) }}" class="btn btn-primary rounded-1 px-4 fw-bold border-0 shadow-none">
                                    Dispense Now
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No pending prescriptions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#prescriptionsTable').DataTable({
        pageLength: 10,
        language: { search: "", searchPlaceholder: "Filter prescriptions..." }
    });
});
</script>
@endpush
@endsection
