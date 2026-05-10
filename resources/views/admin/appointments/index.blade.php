@extends('layouts.admin')

@section('page_title', ($type ?? 'All') . ' Appointments')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="fw-bold mb-0">{{ $type ?? 'All' }} Appointments</h5>
                            <p class="text-muted small mb-0">View and manage {{ strtolower($type ?? 'all') }} patient visits</p>
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
                                                {{ substr($appointment->patient->display_name ?? 'P', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $appointment->patient->display_name ?? 'Unknown Patient' }}</div>
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
                                                'pending' => 'bg-warning-subtle text-warning border-warning',
                                                'confirmed' => 'bg-info-subtle text-info border-info',
                                                'completed' => 'bg-success-subtle text-success border-success',
                                                'cancelled' => 'bg-danger-subtle text-danger border-danger',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <div class="dropdown d-inline-block">
                                            <button class="badge {{ $statusClass }} border px-2 py-1 fw-bold text-uppercase dropdown-toggle shadow-none" 
                                                    style="font-size: 0.65rem; cursor: pointer;" 
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $appointment->status }}
                                            </button>
                                            <ul class="dropdown-menu shadow border-0 py-2">
                                                <li><a class="dropdown-item small py-2 update-status" href="#" data-id="{{ $appointment->id }}" data-status="pending">Pending</a></li>
                                                <li><a class="dropdown-item small py-2 update-status" href="#" data-id="{{ $appointment->id }}" data-status="confirmed">Confirmed</a></li>
                                                <li><a class="dropdown-item small py-2 update-status" href="#" data-id="{{ $appointment->id }}" data-status="completed">Completed</a></li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li><a class="dropdown-item small py-2 update-status text-danger" href="#" data-id="{{ $appointment->id }}" data-status="cancelled">Cancel Appointment</a></li>
                                            </ul>
                                        </div>
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
            },
            initComplete: function () {
                this.api().columns(3).every(function () {
                    var column = this;
                    var select = $('<select class="form-select form-select-sm ms-2" style="width: 150px;"><option value="">All Status</option></select>')
                        .appendTo('#appointmentsTable_filter')
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    column.data().unique().sort().each(function (d, j) {
                        var status = $(d).text().trim();
                        if (status) {
                            select.append('<option value="' + status + '">' + status + '</option>');
                        }
                    });
                });
            }
        });

        // Update status AJAX
        $('.update-status').on('click', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const status = $(this).data('status');
            const $this = $(this);

            Swal.fire({
                title: 'Update Status?',
                text: `Set appointment status to ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'No, keep current'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/appointments') }}/${id}/status`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(resp) {
                            if(resp.success) {
                                Swal.fire('Updated!', resp.message, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to update status', 'error');
                        }
                    });
                }
            });
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

