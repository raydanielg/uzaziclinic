@extends('layouts.app')

@section('content')
<div class="patient-details py-4">
    <div class="container-fluid">
        <!-- Header Info -->
        <div class="row mb-4 animate__animated animate__fadeInDown">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden position-relative">
                    <div class="position-absolute end-0 top-0 p-4 opacity-10">
                        <i class="fa-solid fa-user-doctor fa-8x"></i>
                    </div>
                    <div class="d-flex align-items-center position-relative">
                        <div class="bg-primary-subtle text-primary rounded-circle p-4 me-4 shadow-sm">
                            <i class="fa-solid fa-user fa-3x"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">{{ $patient->name }}</h2>
                            <div class="d-flex gap-3 small text-muted">
                                <span><i class="fa-solid fa-id-card me-1"></i> ID: #PT-{{ $patient->id }}</span>
                                <span><i class="fa-solid fa-envelope me-1"></i> {{ $patient->email }}</span>
                                <span><i class="fa-solid fa-phone me-1"></i> {{ $patient->phone ?? 'No Phone' }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold">Active Patient</span>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2 ms-2 fw-bold">Joined {{ $patient->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="ms-auto text-end">
                            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0 fw-bold mb-2">
                                <i class="fa-solid fa-plus me-2"></i> New Appointment
                            </button>
                            <br>
                            <a href="{{ route('doctor.patients') }}" class="btn btn-light rounded-1 px-4 border-0 small text-muted">
                                <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 animate__animated animate__fadeInUp">
            <!-- Left Column: Tabs Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <ul class="nav nav-tabs border-0 bg-light p-1 rounded-1 mb-4" id="patientTab" role="tablist">
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link active border-0 rounded-1 small fw-bold text-uppercase py-2" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Appointment History</button>
                        </li>
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link border-0 rounded-1 small fw-bold text-uppercase py-2" id="records-tab" data-bs-toggle="tab" data-bs-target="#records" type="button" role="tab">Medical Records</button>
                        </li>
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link border-0 rounded-1 small fw-bold text-uppercase py-2" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button" role="tab">Vitals & Labs</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="patientTabContent">
                        <!-- History Tab -->
                        <div class="tab-pane fade show active" id="history" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3 small text-uppercase fw-bold text-muted border-0">Date</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Type</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Diagnosis</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0 text-center">Status</th>
                                            <th class="text-end pe-3 small text-uppercase fw-bold text-muted border-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($appointments as $app)
                                        <tr>
                                            <td class="ps-3">
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($app->appointment_date)->format('M d, Y') }}</div>
                                                <div class="small text-muted">{{ \Carbon\Carbon::parse($app->appointment_date)->format('H:i A') }}</div>
                                            </td>
                                            <td><span class="small fw-bold">{{ $app->type ?? 'Checkup' }}</span></td>
                                            <td><p class="small mb-0 text-truncate" style="max-width: 200px;">{{ $app->diagnosis ?? 'Routine checkup and general evaluation.' }}</p></td>
                                            <td class="text-center">
                                                <span class="badge {{ $app->status == 'completed' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded-pill px-3">{{ ucfirst($app->status) }}</span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-file-invoice"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted small">No appointment history found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Records Tab -->
                        <div class="tab-pane fade" id="records" role="tabpanel">
                            <div class="text-center py-5">
                                <i class="fa-solid fa-folder-open fa-3x text-muted opacity-25 mb-3"></i>
                                <h6 class="text-muted">Digital Clinical Records</h6>
                                <p class="small text-muted">No clinical records uploaded for this patient yet.</p>
                                <button class="btn btn-sm btn-primary rounded-1 px-4 mt-2">Upload Record</button>
                            </div>
                        </div>

                        <!-- Vitals Tab -->
                        <div class="tab-pane fade" id="vitals" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="p-3 bg-light rounded-1 text-center border border-light">
                                        <div class="small text-muted text-uppercase fw-bold mb-1">Blood Pressure</div>
                                        <div class="h5 fw-bold mb-0">120/80</div>
                                        <div class="small text-success mt-1">Normal</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light rounded-1 text-center border border-light">
                                        <div class="small text-muted text-uppercase fw-bold mb-1">Heart Rate</div>
                                        <div class="h5 fw-bold mb-0">72 bpm</div>
                                        <div class="small text-success mt-1">Stable</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light rounded-1 text-center border border-light">
                                        <div class="small text-muted text-uppercase fw-bold mb-1">Temperature</div>
                                        <div class="h5 fw-bold mb-0">36.5°C</div>
                                        <div class="small text-success mt-1">Normal</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 bg-light rounded-1 text-center border border-light">
                                        <div class="small text-muted text-uppercase fw-bold mb-1">Weight</div>
                                        <div class="h5 fw-bold mb-0">68 kg</div>
                                        <div class="small text-muted mt-1">Last: 1 month ago</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Notes & Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-dark text-white">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-notes-medical me-2 text-warning"></i>Doctor's Notes</h5>
                    <textarea class="form-control bg-white bg-opacity-10 border-0 text-white rounded-1 mb-3" rows="6" placeholder="Quick medical notes for this patient..."></textarea>
                    <button class="btn btn-warning rounded-1 w-100 fw-bold">Save Session Notes</button>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Health Risks</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">Diabetes Type 2</span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">Hypertension</span>
                    </div>

                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Allergies</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-danger rounded-pill px-3 py-2">Penicillin</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Peanuts</span>
                    </div>

                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Recent Prescriptions</h6>
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item px-0 py-2 border-0">
                            <div class="fw-bold">Metformin 500mg</div>
                            <div class="text-muted">1 tablet twice daily • 30 days</div>
                        </div>
                        <div class="list-group-item px-0 py-2 border-light">
                            <div class="fw-bold">Lisinopril 10mg</div>
                            <div class="text-muted">1 tablet daily • 60 days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 1px; }
    .nav-tabs .nav-link.active {
        background-color: white !important;
        color: var(--bs-primary) !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection
