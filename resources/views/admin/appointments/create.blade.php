@extends('layouts.admin')

@section('page_title', 'Create Appointment')

@section('content')
<div class="container-fluid px-0">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Schedule New Appointment</h5>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-pills mb-4 bg-light p-1 rounded" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link active w-100 py-2 border-0" id="existing-tab" data-bs-toggle="pill" data-bs-target="#existing-patient" type="button">
                                <i class="fa-solid fa-search me-2"></i>Existing Patient
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 py-2 border-0" id="new-tab" data-bs-toggle="pill" data-bs-target="#new-patient" type="button">
                                <i class="fa-solid fa-user-plus me-2"></i>New Patient
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab 1: Existing Patient -->
                        <div class="tab-pane fade show active" id="existing-patient" role="tabpanel">
                            <form id="appointmentForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Select Patient</label>
                                        <select name="patient_id" id="patient_select" class="form-select shadow-none" required>
                                            <option value="">Search for a patient...</option>
                                            @foreach($patients as $p)
                                                <option value="{{ $p->id }}">
                                                    PT-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }} | {{ $p->name }} ({{ $p->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Doctor</label>
                                        <select name="doctor_id" class="form-select shadow-none" required>
                                            <option value="">Select Doctor...</option>
                                            @foreach($doctors as $d)
                                                <option value="{{ $d->id }}">
                                                    Dr. {{ $d->name ?? ($d->user->name ?? 'N/A') }} - {{ $d->specialization ?? 'General' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Date & Time</label>
                                        <input type="datetime-local" name="appointment_date" class="form-control shadow-none" required min="{{ date('Y-m-d\TH:i') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Reason / Symptoms</label>
                                    <textarea name="symptoms" class="form-control shadow-none" rows="4" placeholder="Briefly describe the symptoms or reason for visit"></textarea>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary py-2 shadow-sm">
                                        <span id="apptBtnText">Schedule Appointment</span>
                                        <span id="apptBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tab 2: Quick Register New Patient -->
                        <div class="tab-pane fade" id="new-patient" role="tabpanel">
                            <form id="quickPatientForm">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Full Name</label>
                                        <input type="text" name="name" class="form-control shadow-none" required placeholder="Enter full name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control shadow-none" required placeholder="e.g. +255...">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Gender</label>
                                        <select name="gender" class="form-select shadow-none">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Email (Optional)</label>
                                    <input type="email" name="email" class="form-control shadow-none" placeholder="patient@example.com">
                                    <div class="form-text small mt-1">If provided, an account will be created automatically.</div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-success py-2 shadow-sm">
                                        <span id="regBtnText">Register Patient</span>
                                        <span id="regBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle Appointment Submission
        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $('#apptBtnText');
            const $spinner = $('#apptBtnSpinner');
            
            $btn.addClass('d-none');
            $spinner.removeClass('d-none');

            $.ajax({
                url: "{{ route('admin.appointments.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 2000, showConfirmButton: false })
                        .then(() => window.location.href = "{{ route('admin.appointments.index') }}");
                },
                error: function(xhr) {
                    $btn.removeClass('d-none');
                    $spinner.addClass('d-none');
                    const errors = xhr.responseJSON.errors;
                    let errorMsg = 'Check your input and try again.';
                    if(errors) errorMsg = Object.values(errors).flat().join('<br>');
                    Swal.fire({ icon: 'error', title: 'Error', html: errorMsg });
                }
            });
        });

        // Handle Quick Patient Registration
        $('#quickPatientForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $('#regBtnText');
            const $spinner = $('#regBtnSpinner');
            
            $btn.addClass('d-none');
            $spinner.removeClass('d-none');

            $.ajax({
                url: "{{ route('admin.appointments.quick-patient') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success && response.data) {
                        const patient = response.data;
                        Swal.fire({ icon: 'success', title: 'Patient Registered!', text: response.message, timer: 1500, showConfirmButton: false });
                        
                        // Add and select the new patient
                        const patientId = String(patient.id).padStart(3, '0');
                        const displayText = 'PT-' + patientId + ' | ' + patient.name + ' (' + patient.phone + ')';
                        const newOption = new Option(displayText, patient.id, true, true);
                        $('#patient_select').append(newOption).trigger('change');
                        
                        // Switch back to appointment tab
                        const existingTab = document.querySelector('#existing-tab');
                        const bootstrapTab = new bootstrap.Tab(existingTab);
                        bootstrapTab.show();
                        
                        $('#quickPatientForm')[0].reset();
                    }
                    $btn.removeClass('d-none');
                    $spinner.addClass('d-none');
                },
                error: function(xhr) {
                    $btn.removeClass('d-none');
                    $spinner.addClass('d-none');
                    const errors = xhr.responseJSON.errors;
                    let errorMsg = 'Registration failed.';
                    if(errors) errorMsg = Object.values(errors).flat().join('<br>');
                    Swal.fire({ icon: 'error', title: 'Error', html: errorMsg });
                }
            });
        });
    });
</script>
@endpush

<style>
    .nav-pills .nav-link { color: #64748b; font-weight: 500; font-size: 0.9rem; }
    .nav-pills .nav-link.active { background-color: #fff; color: #6366f1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .form-control, .form-select { border-radius: 4px; padding: 0.75rem; border: 1px solid #e2e8f0; font-size: 0.9rem; }
</style>
@endsection
