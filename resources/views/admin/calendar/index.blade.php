@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-calendar-days me-2"></i>Appointment Calendar</h4>
            <p class="text-muted small mb-0">View and manage all appointments</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.calendar.create') }}" class="btn btn-primary fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-plus me-2"></i>Schedule Appointment
            </a>
        </div>
    </div>

    <!-- Filter by Doctor -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Filter by Doctor:</label>
                    <select id="doctorFilter" class="form-select">
                        <option value="">All Doctors</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Filter by Status:</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="card border-0 shadow">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    const appointments = @json($appointments->map(function($app) {
        return [
            'id' => $app->id,
            'title' => $app->patient->user->name . ' - Dr. ' . $app->doctor->user->name,
            'start' => $app->appointment_date,
            'end' => date('Y-m-d H:i:s', strtotime($app->appointment_date) + 3600),
            'backgroundColor' => $app->status === 'confirmed' ? '#22c55e' : ($app->status === 'pending' ? '#f59e0b' : '#6366f1'),
            'borderColor' => $app->status === 'confirmed' ? '#16a34a' : ($app->status === 'pending' ? '#d97706' : '#4f46e5'),
            'extendedProps' => {
                'patient' => $app->patient->user->name,
                'doctor' => $app->doctor->user->name,
                'doctor_id' => $app->doctor->id,
                'status' => $app->status,
                'symptoms' => $app->symptoms
            }
        ];
    }));

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: appointments,
        eventClick: function(info) {
            const event = info.event;
            Swal.fire({
                title: 'Appointment Details',
                html: `
                    <div style="text-align:left">
                        <p><strong>Patient:</strong> ${event.extendedProps.patient}</p>
                        <p><strong>Doctor:</strong> ${event.extendedProps.doctor}</p>
                        <p><strong>Date:</strong> ${event.start.toLocaleString()}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${event.extendedProps.status === 'confirmed' ? 'success' : (event.extendedProps.status === 'pending' ? 'warning' : 'primary')}">${event.extendedProps.status}</span></p>
                        <p><strong>Symptoms:</strong> ${event.extendedProps.symptoms || 'N/A'}</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'View Schedule',
                cancelButtonText: 'Close',
                confirmButtonColor: '#3b82f6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/calendar/user/' + event.extendedProps.doctor_id;
                }
            });
        }
    });

    calendar.render();

    // Filter functionality
    document.getElementById('doctorFilter').addEventListener('change', function() {
        const doctorId = this.value;
        const status = document.getElementById('statusFilter').value;
        
        calendar.getEvents().forEach(event => {
            if (doctorId && event.extendedProps.doctor_id != doctorId) {
                event.setProp('display', 'none');
            } else if (status && event.extendedProps.status !== status) {
                event.setProp('display', 'none');
            } else {
                event.setProp('display', 'auto');
            }
        });
    });

    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const doctorId = document.getElementById('doctorFilter').value;
        
        calendar.getEvents().forEach(event => {
            if (status && event.extendedProps.status !== status) {
                event.setProp('display', 'none');
            } else if (doctorId && event.extendedProps.doctor_id != doctorId) {
                event.setProp('display', 'none');
            } else {
                event.setProp('display', 'auto');
            }
        });
    });
});
</script>
@endpush
@endsection
