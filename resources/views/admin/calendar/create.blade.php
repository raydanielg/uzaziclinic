@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-plus me-2"></i>Schedule New Appointment</h4>
            <p class="text-muted small mb-0">Create a new appointment for a patient</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.calendar.index') }}" class="btn btn-light fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Calendar
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger border-0">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.calendar.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Patient *</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} (PT-{{ $patient->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Doctor *</label>
                        <select name="doctor_id" class="form-select" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->specialization ?? 'General' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Date *</label>
                        <input type="date" name="appointment_date" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Time *</label>
                        <input type="time" name="appointment_time" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Symptoms / Reason</label>
                        <textarea name="symptoms" rows="3" class="form-control" placeholder="Describe the reason for appointment..."></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary fw-semibold rounded-2 px-4">
                        <i class="fa-solid fa-calendar-check me-2"></i>Schedule Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Combine date and time into datetime
document.querySelector('form').addEventListener('submit', function(e) {
    const date = document.querySelector('input[name="appointment_date"]').value;
    const time = document.querySelector('input[name="appointment_time"]').value;
    
    if (date && time) {
        const datetime = date + ' ' + time;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'appointment_date';
        input.value = datetime;
        this.appendChild(input);
        
        // Remove original date and time inputs
        document.querySelector('input[name="appointment_date"]').remove();
        document.querySelector('input[name="appointment_time"]').remove();
    }
});
</script>
@endpush
@endsection
