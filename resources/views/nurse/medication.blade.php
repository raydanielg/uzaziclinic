@extends('layouts.app')

@section('content')
<div class="nurse-medication py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Medication Administration</h1>
                <p class="text-muted small mb-0">Record and track medication given to patients.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addMedModal">
                    <i class="fa-solid fa-plus me-2"></i> Record Medication
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3"><i class="fa-solid fa-pills fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Scheduled Today</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3"><i class="fa-solid fa-check-circle fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Administered</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3"><i class="fa-solid fa-clock fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Pending</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-soft text-danger p-3 rounded-4 me-3"><i class="fa-solid fa-triangle-exclamation fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Missed</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medication Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-syringe me-2 text-primary"></i>Today's Medication Schedule</h5>
                <div class="input-group" style="max-width: 260px;">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Search patient...">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="medicationTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                <th class="small text-uppercase fw-bold text-muted border-0">Medication</th>
                                <th class="small text-uppercase fw-bold text-muted border-0">Dosage</th>
                                <th class="small text-uppercase fw-bold text-muted border-0">Time</th>
                                <th class="small text-uppercase fw-bold text-muted border-0">Route</th>
                                <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                                <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-pills fs-2 mb-2 d-block opacity-25"></i>
                                    No medication schedule for today.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Record Medication Modal -->
<div class="modal fade" id="addMedModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-pills me-2"></i>Record Medication</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Patient Name</label>
                        <input type="text" class="form-control" placeholder="Search patient...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ward / Bed</label>
                        <input type="text" class="form-control" placeholder="Ward A - Bed 3">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Medication Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Paracetamol 500mg">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Dosage</label>
                        <input type="text" class="form-control" placeholder="e.g. 1 tablet">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Route</label>
                        <select class="form-select">
                            <option>Oral</option>
                            <option>IV</option>
                            <option>IM</option>
                            <option>Topical</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Time Administered</label>
                        <input type="datetime-local" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Administered By</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Notes</label>
                        <textarea class="form-control" rows="2" placeholder="Any observations or notes..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-1 px-4">
                    <i class="fa-solid fa-save me-2"></i>Record
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection
