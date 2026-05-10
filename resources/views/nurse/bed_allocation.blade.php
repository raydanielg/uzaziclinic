@extends('layouts.app')

@section('content')
<div class="nurse-beds py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0 text-dark">Bed Allocation</h4>
                <p class="text-muted small">Manage patient admissions and bed assignments across wards.</p>
            </div>
            <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0 fw-bold" data-bs-toggle="modal" data-bs-target="#admitPatientModal">
                <i class="fa-solid fa-plus me-2"></i> Admit Patient
            </button>
        </div>

        <div class="row g-4">
            @foreach($wards as $ward)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">{{ $ward->name }}</h5>
                            <span class="badge bg-primary-subtle text-primary rounded-pill small">{{ ucfirst($ward->type) }}</span>
                        </div>
                        <span class="small text-muted">{{ $ward->beds->where('status', 'occupied')->count() }}/{{ $ward->beds->count() }} Occupied</span>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row g-3">
                            @foreach($ward->beds as $bed)
                            <div class="col-md-4 col-6">
                                <div class="p-3 rounded-4 border {{ $bed->status == 'available' ? 'border-success-subtle bg-success-soft text-success' : ($bed->status == 'occupied' ? 'border-danger-subtle bg-danger-soft text-danger' : 'border-light bg-light text-muted') }} text-center position-relative">
                                    <i class="fa-solid fa-bed fs-2 mb-2"></i>
                                    <div class="small fw-bold">#{{ $bed->bed_number }}</div>
                                    <div style="font-size: 0.6rem;" class="text-uppercase ls-1 opacity-75">{{ $bed->status }}</div>
                                    
                                    @if($bed->status == 'occupied')
                                    <button class="btn btn-sm btn-white rounded-circle position-absolute top-0 end-0 m-1 shadow-none border-0" data-bs-toggle="tooltip" title="Patient: Jane Doe">
                                        <i class="fa-solid fa-info-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Admission Modal -->
<div class="modal fade" id="admitPatientModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary">Admit New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Patient</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none" required>
                                <option value="">Select patient...</option>
                                @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Ward & Bed</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none" required>
                                <option value="">Choose available bed...</option>
                                @foreach($wards as $ward)
                                    @foreach($ward->beds->where('status', 'available') as $bed)
                                    <option value="{{ $bed->id }}">{{ $ward->name }} - Bed {{ $bed->bed_number }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Admission Reason</label>
                            <textarea class="form-control rounded-1 border-light bg-light shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary rounded-1 px-5 fw-bold border-0">Admit Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.05); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.05); }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
