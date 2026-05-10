@extends('layouts.app')

@section('content')
<div class="nurse-appointments py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Today's Appointments</h4>
                <p class="text-muted small">Full schedule of all medical appointments for today.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="appointmentsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Time</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $app)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i A') }}</div>
                            </td>
                            <td class="fw-bold">{{ $app->user->name ?? 'N/A' }}</td>
                            <td>Dr. {{ $app->doctor->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $app->status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary' }} rounded-pill px-3">{{ ucfirst($app->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No appointments for today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
