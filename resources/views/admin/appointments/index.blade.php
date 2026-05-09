@extends('layouts.admin')

@section('page_title', 'Appointment Management')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="fw-bold mb-0">Appointments List</h5>
                            <p class="text-muted small mb-0">View and manage patient visits and doctor schedules</p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary px-4 shadow-sm">
                                <i class="fa-solid fa-calendar-plus me-2"></i> New Appointment
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="appointmentsTable" class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-2">PATIENT</th>
                                    <th>DOCTOR</th>
                                    <th>DATE & TIME</th>
                                    <th>STATUS</th>
                                    <th class="text-end pe-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments ?? [] as $appointment)
                                <tr>
                                    <td class="ps-2">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-primary-subtle text-primary rounded-1 d-flex align-items-center justify-content-center fw-bold me-3" style="width: 45px; height: 45px;">
                                                {{ substr($appointment->patient->name ?? 'P', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $appointment->patient->name ?? 'Unknown Patient' }}</div>
                                                <div class="text-muted small">
                                                    <span class="text-primary fw-medium">{{ $appointment->patient->patient_number }}</span> 
                                                    | {{ $appointment->patient->phone ?? '---' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">Dr. {{ $appointment->doctor->display_name ?? 'N/A' }}</div>
                                        <div class="text-muted small">{{ $appointment->doctor->specialization ?? 'General' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                                        <div class="text-muted small">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($appointment->status) {
                                                'pending' => 'bg-warning-subtle text-warning border-warning-subtle',
                                                'confirmed' => 'bg-info-subtle text-info border-info-subtle',
                                                'completed' => 'bg-success-subtle text-success border-success-subtle',
                                                'cancelled' => 'bg-danger-subtle text-danger border-danger-subtle',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} border px-2 py-1 fw-normal text-uppercase" style="font-size: 0.65rem;">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-2">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-secondary" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmCancel({{ $appointment->id }})" title="Cancel">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#appointmentsTable').DataTable({
            responsive: true,
            order: [[2, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search appointments...",
                lengthMenu: "Show _MENU_ entries"
            }
        });
    });

    function confirmCancel(id) {
        Swal.fire({
            title: 'Cancel Appointment?',
            text: "Are you sure you want to cancel this appointment?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Implementation for cancellation
                Swal.fire('Cancelled!', 'Appointment has been cancelled.', 'success');
            }
        })
    }
</script>
@endpush


<style>
    .nav-pills .nav-link {
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .nav-pills .nav-link.active {
        background-color: #fff;
        color: #6366f1;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .form-control, .form-select {
        border-radius: 4px;
        padding: 0.6rem 0.75rem;
        border: 1px solid #e2e8f0;
        font-size: 0.9rem;
    }
    .table thead th {
        font-size: 0.75rem !important;
        letter-spacing: 0.5px;
        background: #f8fafc !important;
        color: #64748b !important;
        text-transform: uppercase;
    }
    .avatar {
        background-color: #f0f4ff;
    }
</style>
@endsection

