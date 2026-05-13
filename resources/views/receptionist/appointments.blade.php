@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Appointments</h1>
                <p class="text-muted small mb-0">Manage patient appointments. Book, reschedule or cancel.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#bookModal">
                    <i class="fa-solid fa-calendar-plus me-2"></i>Book Appointment
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-primary">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Today</p>
                    <h3 class="fw-bold mb-0">{{ $appointments->where('appointment_date', today()->toDateString())->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-warning">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Pending</p>
                    <h3 class="fw-bold mb-0 text-warning">{{ $appointments->where('status','pending')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-success">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Confirmed</p>
                    <h3 class="fw-bold mb-0 text-success">{{ $appointments->where('status','confirmed')->count() }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-4 border-secondary">
                    <p class="small text-muted fw-bold text-uppercase mb-1">Total</p>
                    <h3 class="fw-bold mb-0">{{ $appointments->total() }}</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-primary"></i>All Appointments</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Confirmed</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>
                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" style="width:auto;">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="apptTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">#</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Patient</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Doctor</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Date & Time</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Type</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appt)
                            <tr>
                                <td class="ps-4 text-muted small">#{{ $appt->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $appt->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $appt->user->phone ?? '' }}</small>
                                </td>
                                <td>Dr. {{ $appt->doctor->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('H:i') }}</small>
                                </td>
                                <td class="small text-muted">{{ ucfirst($appt->type ?? 'General') }}</td>
                                <td>
                                    @php
                                        $st = $appt->status ?? 'pending';
                                        $cls = match($st) { 'confirmed'=>'primary','completed'=>'success','cancelled'=>'danger', default=>'warning' };
                                    @endphp
                                    <span class="badge bg-{{ $cls }}-subtle text-{{ $cls }} rounded-pill">{{ ucfirst($st) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-success rounded-2 me-1" title="Confirm">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-2" title="Cancel">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-calendar-xmark fs-2 d-block mb-2 opacity-25"></i>
                                    No appointments found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($appointments->hasPages())
            <div class="card-footer bg-white border-0">{{ $appointments->links() }}</div>
            @endif
        </div>
    </div>
</div>

<!-- Book Appointment Modal -->
<div class="modal fade" id="bookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-calendar-plus me-2"></i>Book New Appointment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Patient Name</label>
                        <input type="text" class="form-control" placeholder="Search or enter patient name...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Phone Number</label>
                        <input type="text" class="form-control" placeholder="+255 7XX XXX XXX">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Doctor</label>
                        <select class="form-select">
                            <option value="">Select Doctor</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Appointment Type</label>
                        <select class="form-select">
                            <option>General Consultation</option>
                            <option>Follow-up</option>
                            <option>Emergency</option>
                            <option>Lab Test</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" class="form-control" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Time</label>
                        <input type="time" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Reason for visit or special notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4"><i class="fa-solid fa-save me-2"></i>Book</button>
            </div>
        </div>
    </div>
</div>
@endsection
