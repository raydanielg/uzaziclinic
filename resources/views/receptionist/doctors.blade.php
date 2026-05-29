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
                            <a href="{{ route('receptionist.visits.queue') }}" class="btn btn-sm btn-primary rounded-2">
                                <i class="fa-solid fa-calendar-plus me-1"></i>Send Patient
                            </a>
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

@push('scripts')
<script>
document.getElementById('doctorSearch')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.doctor-card').forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endpush
@endsection
