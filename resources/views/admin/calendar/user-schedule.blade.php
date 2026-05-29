@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-calendar-user me-2"></i>User Schedule</h4>
            <p class="text-muted small mb-0">View appointments for specific user</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.calendar.index') }}" class="btn btn-light fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Calendar
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Symptoms</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $appointment->appointment_date->format('d M Y') }}</div>
                                <div class="small text-muted">{{ $appointment->appointment_date->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar bg-blue-soft text-blue" style="width:32px;height:32px;font-size:.8rem">
                                        {{ strtoupper(substr($appointment->patient->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $appointment->patient->user->name }}</div>
                                        <div class="text-muted" style="font-size:.7rem">PT-{{ $appointment->patient->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar bg-green-soft text-green" style="width:32px;height:32px;font-size:.8rem">
                                        {{ strtoupper(substr($appointment->doctor->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">Dr. {{ $appointment->doctor->user->name }}</div>
                                        <div class="text-muted" style="font-size:.7rem">{{ $appointment->doctor->specialization ?? 'General' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($appointment->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($appointment->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-primary">Completed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="small text-muted" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                    {{ $appointment->symptoms ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-end">
                                @if($appointment->status !== 'cancelled')
                                <form action="{{ route('admin.calendar.destroy', $appointment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-2" onclick="return confirm('Are you sure you want to cancel this appointment?')" title="Cancel">
                                        <i class="fa-solid fa-xmark text-rose"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>
                                No appointments found for this user
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
