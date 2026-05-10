@extends('layouts.app')

@section('content')
<div class="doctor-prescription py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden position-relative">
                    <div class="position-absolute end-0 top-0 p-4 opacity-10">
                        <i class="fa-solid fa-file-prescription fa-6x"></i>
                    </div>
                    <div class="position-relative">
                        <h4 class="fw-bold mb-1 text-primary">New Prescription</h4>
                        <p class="text-muted small mb-4">Create and issue medical prescriptions to patients</p>
                    </div>
                    
                    <form id="prescriptionForm">
                        @csrf
                        <div class="row g-4">
                            <!-- Patient Selection -->
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Select Patient</label>
                                <select name="patient_id" class="form-select rounded-1 border-light bg-light shadow-none py-2" required>
                                    <option value="">Choose a patient...</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} (#PT-{{ $patient->id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Diagnosis -->
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Diagnosis / Clinical Findings</label>
                                <textarea name="diagnosis" class="form-control rounded-1 border-light bg-light shadow-none" rows="2" placeholder="Enter patient diagnosis..." required></textarea>
                            </div>

                            <!-- Medicines Section -->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1 mb-0">Medicines & Dosage</label>
                                    <button type="button" class="btn btn-sm btn-primary rounded-1 px-3" id="addMedicineRow">
                                        <i class="fa-solid fa-plus me-1"></i> Add Medicine
                                    </button>
                                </div>
                                
                                <div id="medicineItems">
                                    <div class="medicine-row row g-2 mb-3 align-items-end p-3 bg-light rounded-1 border border-light position-relative">
                                        <div class="col-md-5">
                                            <label class="small text-muted mb-1 fw-bold">Medicine Name</label>
                                            <input type="text" name="medicines[0][name]" class="form-control form-control-sm rounded-1 border-0 shadow-none medicine-search" list="medicineList" placeholder="Search or type medicine name..." required>
                                            <datalist id="medicineList">
                                                @foreach($medicines as $med)
                                                    <option value="{{ $med->name }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small text-muted mb-1 fw-bold">Dosage</label>
                                            <input type="text" name="medicines[0][dosage]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 500mg" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small text-muted mb-1 fw-bold">Frequency</label>
                                            <input type="text" name="medicines[0][frequency]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 1x3" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small text-muted mb-1 fw-bold">Duration</label>
                                            <input type="text" name="medicines[0][duration]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 5 Days">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-1 remove-row" style="display: none;"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Pharmacist Instructions / Notes</label>
                                <textarea name="notes" class="form-control rounded-1 border-light bg-light shadow-none" rows="3" placeholder="Additional instructions for the patient or pharmacist..."></textarea>
                            </div>

                            <div class="col-md-12 text-end pt-3 border-top">
                                <button type="submit" class="btn btn-primary rounded-1 px-5 py-2 shadow-sm border-0 fw-bold" id="submitBtn">
                                    <i class="fa-solid fa-save me-2"></i> Save Prescription
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let rowIndex = 1;

    // Add new medicine row
    $('#addMedicineRow').click(function() {
        const newRow = `
            <div class="medicine-row row g-2 mb-3 align-items-end p-3 bg-light rounded-1 border border-light animate__animated animate__fadeIn">
                <div class="col-md-5">
                    <label class="small text-muted mb-1 fw-bold">Medicine Name</label>
                    <input type="text" name="medicines[${rowIndex}][name]" class="form-control form-control-sm rounded-1 border-0 shadow-none medicine-search" list="medicineList" placeholder="Search or type medicine name..." required>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted mb-1 fw-bold">Dosage</label>
                    <input type="text" name="medicines[${rowIndex}][dosage]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 500mg" required>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted mb-1 fw-bold">Frequency</label>
                    <input type="text" name="medicines[${rowIndex}][frequency]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 1x3" required>
                </div>
                <div class="col-md-2">
                    <label class="small text-muted mb-1 fw-bold">Duration</label>
                    <input type="text" name="medicines[${rowIndex}][duration]" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. 5 Days">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-1 remove-row"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>`;
        $('#medicineItems').append(newRow);
        rowIndex++;
        updateRemoveButtons();
    });

    // Remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.medicine-row').remove();
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        if ($('.medicine-row').length > 1) {
            $('.remove-row').show();
        } else {
            $('.remove-row').hide();
        }
    }

    // Form Submission
    $('#prescriptionForm').submit(function(e) {
        e.preventDefault();
        const $btn = $('#submitBtn');
        const originalText = $btn.html();

        Swal.fire({
            title: 'Issue Prescription?',
            text: "Are you sure you want to save this prescription?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...').prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('doctor.prescriptions.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(resp) {
                        $btn.html(originalText).prop('disabled', false);
                        if(resp.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: resp.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('doctor.dashboard') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        $btn.html(originalText).prop('disabled', false);
                        let msg = 'Failed to save prescription';
                        if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        Swal.fire('Error!', msg, 'error');
                    }
                });
            }
        });
    });
});
</script>
<style>
    .ls-1 { letter-spacing: 1px; }
</style>
@endpush
@endsection
