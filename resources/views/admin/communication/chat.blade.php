@extends('layouts.admin')

@section('page_title', 'Chat with Doctor')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Communication (Mawasiliano)</h1>
            <p class="text-muted small">Wasiliana na madaktari au wagonjwa kwa njia ya ujumbe mfupi.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Contacts -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">Contacts</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-fill border-0 bg-light" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active border-0 rounded-0 py-3 small fw-bold" data-bs-toggle="tab" href="#doctorsTab">DOCTORS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0 rounded-0 py-3 small fw-bold" data-bs-toggle="tab" href="#patientsTab">PATIENTS</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" style="max-height: 500px; overflow-y: auto;">
                        <!-- Doctors Tab -->
                        <div id="doctorsTab" class="tab-pane active p-2">
                            @forelse($doctors as $doctor)
                            <a href="#" class="d-flex align-items-center p-3 text-decoration-none border-bottom contact-item rounded-3 mb-1">
                                <div class="avatar-sm bg-primary-soft text-primary rounded-circle me-3">
                                    {{ substr($doctor->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Dr. {{ $doctor->name }}</div>
                                    <div class="text-muted x-small">Online</div>
                                </div>
                            </a>
                            @empty
                            <div class="p-4 text-center text-muted small">No doctors found.</div>
                            @endforelse
                        </div>
                        
                        <!-- Patients Tab -->
                        <div id="patientsTab" class="tab-pane p-2">
                            @forelse($patients as $patient)
                            <a href="#" class="d-flex align-items-center p-3 text-decoration-none border-bottom contact-item rounded-3 mb-1">
                                <div class="avatar-sm bg-success-soft text-success rounded-circle me-3">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">{{ $patient->name }}</div>
                                    <div class="text-muted x-small">Mgonjwa</div>
                                </div>
                            </a>
                            @empty
                            <div class="p-4 text-center text-muted small">No patients found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 d-flex flex-column" style="min-height: 600px;">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                    <div class="avatar-sm bg-primary-soft text-primary rounded-circle me-3">D</div>
                    <div>
                        <h6 class="mb-0 fw-bold">Select a contact to start chat</h6>
                        <small class="text-success small"><i class="fas fa-circle me-1" style="font-size: 8px;"></i>Online support active</small>
                    </div>
                </div>
                
                <div class="card-body flex-grow-1 bg-light d-flex align-items-center justify-content-center">
                    <div class="text-center opacity-50">
                        <i class="fas fa-comments fa-4x mb-3 text-muted"></i>
                        <h5>No Active Chat</h5>
                        <p class="small">Pata ushauri au jibu maswali kutoka kwa wataalamu.</p>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top p-3">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 bg-light shadow-none py-2" placeholder="Andika ujumbe hapa..." disabled>
                        <button class="btn btn-primary px-4" disabled>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-sm { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .bg-primary-soft { background: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background: rgba(25, 135, 84, 0.1); }
    .x-small { font-size: 0.75rem; }
    .contact-item:hover { background: #f8fafc; }
    .nav-tabs .nav-link.active { background: white !important; color: var(--bs-primary) !important; border-bottom: 2px solid var(--bs-primary) !important; }
</style>
@endsection
