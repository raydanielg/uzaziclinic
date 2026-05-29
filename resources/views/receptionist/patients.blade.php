@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Patient Registry</h1>
                <p class="text-muted small mb-0">Register new patients and manage existing patient records.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="fa-solid fa-user-plus me-2"></i>Register Patient
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users me-2 text-primary"></i>All Patients ({{ $patients->total() }})</h5>
                <div class="input-group" style="max-width:280px;">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-0" id="patientSearch" placeholder="Search patient...">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="patientsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">Patient ID</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Name</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Phone</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Gender</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Registered</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patients as $patient)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">#PT-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width:36px;height:36px;">
                                            <i class="fa-solid fa-user text-muted small"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $patient->name }}</div>
                                            <small class="text-muted">{{ $patient->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">{{ $patient->phone ?? 'N/A' }}</td>
                                <td class="small text-muted">{{ ucfirst($patient->gender ?? 'N/A') }}</td>
                                <td class="small text-muted">{{ $patient->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ ($patient->status ?? 'active') === 'active' ? 'success' : 'secondary' }}-subtle 
                                        text-{{ ($patient->status ?? 'active') === 'active' ? 'success' : 'secondary' }} rounded-pill">
                                        {{ ucfirst($patient->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary rounded-2 me-1" onclick="viewPatient({{ $patient->id }})" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary rounded-2" onclick="editPatient({{ $patient->id }})" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users fs-2 d-block mb-2 opacity-25"></i>
                                    No patients registered yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($patients->hasPages())
            <div class="card-footer bg-white border-0">{{ $patients->links() }}</div>
            @endif
        </div>
    </div>
</div>

<!-- Register Patient Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Register New Patient</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Patient full name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Date of Birth</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Gender</label>
                        <select class="form-select">
                            <option value="">Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="+255 7XX XXX XXX" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" class="form-control" placeholder="patient@email.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">National ID / Passport</label>
                        <input type="text" class="form-control" placeholder="ID number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Blood Type</label>
                        <select class="form-select">
                            <option value="">Unknown</option>
                            <option>A+</option><option>A-</option>
                            <option>B+</option><option>B-</option>
                            <option>O+</option><option>O-</option>
                            <option>AB+</option><option>AB-</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Insurance Provider</label>
                        <input type="text" class="form-control" placeholder="NHIF, Jubilee, etc.">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Address</label>
                        <textarea class="form-control" rows="2" placeholder="Physical address..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Emergency Contact</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="emergency_contact_name" placeholder="Contact name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="emergency_contact_phone" placeholder="Contact phone">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Upload Files (Medical Reports, Insurance, etc.)</label>
                        <input type="file" class="form-control" name="files[]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <small class="text-muted">Allowed: PDF, Images, Word documents (Max 5MB each)</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4"><i class="fa-solid fa-save me-2"></i>Register Patient</button>
            </div>
        </div>
    </div>
</div>

<!-- View Patient Modal -->
<div class="modal fade" id="viewPatientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user me-2"></i>Patient Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="viewPatientContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-warning text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen me-2"></i>Edit Patient</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="editPatientContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-warning" role="status"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-warning rounded-1 px-4" id="updatePatientBtn"><i class="fa-solid fa-save me-2"></i>Update Patient</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewPatient(id) {
    const modal = new bootstrap.Modal(document.getElementById('viewPatientModal'));
    const content = document.getElementById('viewPatientContent');
    
    content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
    modal.show();
    
    fetch(`{{ route('receptionist.patients.view', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.data.patient;
                const profile = data.data.patient_profile;
                const files = data.data.files;
                
                let filesHtml = files.length > 0 
                    ? files.map(f => `
                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                            <div>
                                <small class="fw-semibold">${f.file_name}</small>
                                <br><small class="text-muted">${f.file_type_label} • ${f.file_size}</small>
                            </div>
                            <a href="{{ route('receptionist.files.download', ':file') }}".replace(':file', f.id) class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    `).join('')
                    : '<p class="text-muted small">No files uploaded</p>';
                
                content.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name</label>
                            <div class="fw-semibold">${p.name}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Patient ID</label>
                            <div class="fw-semibold">#PT-${String(p.id).padStart(4, '0')}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email</label>
                            <div>${p.email}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone</label>
                            <div>${p.phone}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Gender</label>
                            <div>${profile?.gender ? profile.gender.charAt(0).toUpperCase() + profile.gender.slice(1) : 'N/A'}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Blood Type</label>
                            <div>${profile?.blood_group || 'N/A'}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Emergency Contact</label>
                            <div>${profile?.emergency_contact || 'N/A'}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Status</label>
                            <span class="badge bg-${p.status === 'active' ? 'success' : 'secondary'}">${p.status.charAt(0).toUpperCase() + p.status.slice(1)}</span>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Registered Date</label>
                            <div>${new Date(p.created_at).toLocaleDateString()}</div>
                        </div>
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold mb-3"><i class="fa-solid fa-file-medical me-2"></i>Patient Files</h6>
                            ${filesHtml}
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            content.innerHTML = '<div class="alert alert-danger">Failed to load patient details</div>';
        });
}

function editPatient(id) {
    const modal = new bootstrap.Modal(document.getElementById('editPatientModal'));
    const content = document.getElementById('editPatientContent');
    
    content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-warning" role="status"></div></div>';
    modal.show();
    
    fetch(`{{ route('receptionist.patients.edit', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const p = data.data.patient;
                const profile = data.data.patient_profile;
                
                content.innerHTML = `
                    <form id="editPatientForm">
                        <input type="hidden" name="patient_id" value="${p.id}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="${p.name}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" value="${p.phone}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="${p.email}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" ${profile?.gender === 'male' ? 'selected' : ''}>Male</option>
                                    <option value="female" ${profile?.gender === 'female' ? 'selected' : ''}>Female</option>
                                    <option value="other" ${profile?.gender === 'other' ? 'selected' : ''}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Blood Type</label>
                                <select class="form-select" name="blood_type">
                                    <option value="">Unknown</option>
                                    <option value="A+" ${profile?.blood_group === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${profile?.blood_group === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${profile?.blood_group === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${profile?.blood_group === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="O+" ${profile?.blood_group === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${profile?.blood_group === 'O-' ? 'selected' : ''}>O-</option>
                                    <option value="AB+" ${profile?.blood_group === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${profile?.blood_group === 'AB-' ? 'selected' : ''}>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="active" ${p.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="inactive" ${p.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Emergency Contact Name</label>
                                <input type="text" class="form-control" name="emergency_contact_name" value="${profile?.emergency_contact?.split(' - ')[0] || ''}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Emergency Contact Phone</label>
                                <input type="text" class="form-control" name="emergency_contact_phone" value="${profile?.emergency_contact?.split(' - ')[1] || ''}">
                            </div>
                        </div>
                    </form>
                `;
            }
        })
        .catch(error => {
            content.innerHTML = '<div class="alert alert-danger">Failed to load patient details</div>';
        });
}

document.getElementById('updatePatientBtn').addEventListener('click', function() {
    const form = document.getElementById('editPatientForm');
    const formData = new FormData(form);
    const patientId = formData.get('patient_id');
    
    const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        gender: formData.get('gender'),
        blood_type: formData.get('blood_type'),
        status: formData.get('status'),
        emergency_contact_name: formData.get('emergency_contact_name'),
        emergency_contact_phone: formData.get('emergency_contact_phone'),
    };
    
    this.disabled = true;
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Updating...';
    
    fetch(`{{ route('receptionist.patients.update', ':id') }}`.replace(':id', patientId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: result.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                bootstrap.Modal.getInstance(document.getElementById('editPatientModal')).hide();
                location.reload();
            });
        } else {
            Swal.fire('Error', 'Failed to update patient', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Failed to update patient', 'error');
    })
    .finally(() => {
        this.disabled = false;
        this.innerHTML = '<i class="fa-solid fa-save me-2"></i>Update Patient';
    });
});
</script>
@endpush
@endsection
