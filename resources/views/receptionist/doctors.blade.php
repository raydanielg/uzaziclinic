@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Doctor Directory</h1>
                <p class="text-muted small mb-0">View available doctors and their schedules for appointment booking.</p>
            </div>
        </div>

        <!-- Search -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0" id="doctorSearch" placeholder="Search doctor by name or specialization...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="specFilter">
                            <option value="">All Specializations</option>
                            <option>General Practitioner</option>
                            <option>Pediatrics</option>
                            <option>Gynecology</option>
                            <option>Surgery</option>
                            <option>Internal Medicine</option>
                            <option>Dentistry</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor Cards Grid -->
        <div class="row g-4" id="doctorGrid">
            @forelse($doctors as $doctor)
            <div class="col-xl-3 col-md-4 col-sm-6 doctor-card">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="bg-{{ ['primary','success','info','warning'][($doctor->id % 4)] }} p-4 text-white text-center">
                        <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                            style="width:70px;height:70px;font-size:1.8rem;">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Dr. {{ $doctor->user->name }}</h6>
                        <small class="opacity-75">{{ $doctor->specialization ?? 'General Practitioner' }}</small>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-users me-2 text-muted small" style="width:16px;"></i>
                                <span class="small">Queue:</span>
                            </div>
                            <span class="badge bg-primary">{{ $doctor->queue_count ?? 0 }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-phone me-2 text-muted small" style="width:16px;"></i>
                            <span class="small">{{ $doctor->user->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-envelope me-2 text-muted small" style="width:16px;"></i>
                            <span class="small text-truncate">{{ $doctor->user->email }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-solid fa-circle me-2 text-{{ ($doctor->status ?? 'active') === 'active' ? 'success' : 'secondary' }} small" style="width:16px;font-size:0.5rem;"></i>
                            <span class="small text-muted">{{ ucfirst($doctor->status ?? 'Active') }}</span>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-sm btn-primary rounded-2" onclick="openSendPatientModal({{ $doctor->id }}, 'Dr. {{ $doctor->user->name }}')">
                                <i class="fa-solid fa-user-plus me-1"></i>Send Patient
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
                    <i class="fa-solid fa-user-doctor fs-1 d-block mb-3 opacity-25"></i>
                    <h5>No doctors found</h5>
                    <p class="mb-0 small">No doctor accounts have been created yet.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Send Patient Modal -->
<div class="modal fade" id="sendPatientModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Send Patient to Doctor</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="selectedDoctorId">
                
                <div class="alert alert-info border-0 mb-4">
                    <div class="fw-bold" id="selectedDoctorName">Doctor Name</div>
                    <div class="small text-muted">Assign a patient to this doctor</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Search Patient</label>
                    <input type="text" id="patientSearch" class="form-control" placeholder="Search by name or patient number...">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Patient</label>
                    <div id="patientList" class="border rounded-2 p-2 bg-light" style="max-height:250px;overflow-y:auto">
                        <div class="text-center text-muted small py-3">Type to search patients...</div>
                    </div>
                    <input type="hidden" id="patientSelect" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Reason / Notes</label>
                    <textarea id="sendNotes" rows="2" class="form-control" placeholder="Enter reason for visit..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4" id="sendPatientBtn">
                    <i class="fa-solid fa-paper-plane me-2"></i>Send to Doctor
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const CSRF = '{{ csrf_token() }}';

// Doctor search
document.getElementById('doctorSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.doctor-card').forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Open send patient modal
window.openSendPatientModal = function(doctorId, doctorName) {
    $('#selectedDoctorId').val(doctorId);
    $('#selectedDoctorName').text(doctorName);
    $('#patientSelect').val('');
    $('#sendNotes').val('');
    $('#patientSearch').val('');
    $('#patientList').html('<div class="text-center text-muted small py-3">Type to search patients...</div>');
    
    const modal = new bootstrap.Modal(document.getElementById('sendPatientModal'));
    modal.show();
};

// Load patients with search
let searchTimeout;
$('#patientSearch').on('input', function() {
    clearTimeout(searchTimeout);
    const q = $(this).val();
    
    if (q.length < 2) {
        $('#patientList').html('<div class="text-center text-muted small py-3">Type at least 2 characters to search...</div>');
        return;
    }
    
    $('#patientList').html('<div class="text-center text-muted small py-3"><i class="fa-solid fa-spinner fa-spin"></i> Searching...</div>');
    
    searchTimeout = setTimeout(function() {
        searchPatients(q);
    }, 300);
});

function searchPatients(query) {
    $.get('{{ route("receptionist.patients.json") }}')
        .done(function(data) {
            const list = $('#patientList');
            list.empty();
            
            const filtered = data.filter(function(patient) {
                const name = patient.name.toLowerCase();
                const number = patient.patient_number.toLowerCase();
                const q = query.toLowerCase();
                return name.includes(q) || number.includes(q);
            });
            
            if (filtered.length === 0) {
                list.html('<div class="text-center text-muted small py-3">No patients found</div>');
                return;
            }
            
            filtered.forEach(function(patient) {
                list.append(`
                    <div class="patient-item p-2 rounded-1 cursor-pointer mb-1" 
                         style="background:#fff;border:1px solid #e5e7eb"
                         data-id="${patient.id}" 
                         data-name="${patient.name}"
                         data-number="${patient.patient_number}">
                        <div class="fw-semibold small">${patient.name}</div>
                        <div class="text-muted" style="font-size:.75rem">${patient.patient_number}</div>
                    </div>
                `);
            });
        })
        .fail(function() {
            $('#patientList').html('<div class="text-center text-danger small py-3">Failed to load patients</div>');
        });
}

// Patient selection
$(document).on('click', '.patient-item', function() {
    $('.patient-item').removeClass('bg-primary text-white');
    $(this).addClass('bg-primary text-white');
    $('#patientSelect').val($(this).data('id'));
});

// Send patient to doctor
$('#sendPatientBtn').on('click', function() {
    const doctorId = $('#selectedDoctorId').val();
    const patientId = $('#patientSelect').val();
    const notes = $('#sendNotes').val();
    
    if (!patientId) {
        return Swal.fire('Warning', 'Please select a patient', 'warning');
    }
    
    const $btn = $(this).prop('disabled', true);
    $btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending...');
    
    $.post('{{ route("receptionist.visits.send") }}', {
        _token: CSRF,
        patient_id: patientId,
        doctor_id: doctorId,
        chief_complaint: notes
    }).done(function(r) {
        if (r.success) {
            Swal.fire({
                icon:'success',
                title:'Patient Sent Successfully!',
                text:'Patient has been assigned to the doctor',
                timer:2000,
                showConfirmButton:false
            }).then(() => {
                bootstrap.Modal.getInstance(document.getElementById('sendPatientModal')).hide();
                location.reload();
            });
        } else {
            Swal.fire('Error', r.message, 'error');
        }
    }).fail(function(xhr) {
        Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
    }).always(function() {
        $btn.prop('disabled', false);
        $btn.html('<i class="fa-solid fa-paper-plane me-2"></i>Send to Doctor');
    });
});
</script>
@endpush
@endsection
