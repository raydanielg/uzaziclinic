@extends('layouts.app')

@section('content')
<div class="nurse-checkin py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Patient Check-in</h4>
                <p class="text-muted small">Verify and check-in patients for their appointments today.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="checkinTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Appointment Time</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Reason</th>
                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending_appointments as $app)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i A') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $app->user->name ?? 'N/A' }}</div>
                                <div class="small text-muted">ID: #PT-{{ $app->user->id }}</div>
                            </td>
                            <td class="small">{{ $app->type ?? 'Routine Checkup' }}</td>
                            <td class="text-center">
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">{{ ucfirst($app->status) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-primary rounded-1 px-4 fw-bold shadow-none border-0">
                                    Check In
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No pending appointments for today.</td>
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
    $('#checkinTable').DataTable({
        pageLength: 10,
        language: { search: "", searchPlaceholder: "Search patients..." }
    });
});
</script>
@endpush
@endsection
