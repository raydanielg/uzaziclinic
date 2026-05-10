@extends('layouts.app')

@section('content')
<div class="doctor-prescription py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-primary"><i class="fa-solid fa-file-prescription me-2"></i>Write New Prescription</h4>
                    
                    <form id="prescriptionForm">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Select Patient</label>
                                <select class="form-select rounded-1 border-light bg-light shadow-none" required>
                                    <option value="">Choose a patient...</option>
                                    <!-- Populated from DB -->
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Diagnosis</label>
                                <textarea class="form-control rounded-1 border-light bg-light shadow-none" rows="2" placeholder="Enter diagnosis..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase mb-0">Medicines</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-1 px-3" id="addMedicine">
                                        <i class="fa-solid fa-plus me-1"></i> Add Item
                                    </button>
                                </div>
                                <div id="medicineList">
                                    <div class="medicine-item row g-2 mb-3 align-items-end p-3 bg-light rounded-1 border border-light">
                                        <div class="col-md-5">
                                            <label class="small text-muted mb-1">Medicine Name</label>
                                            <input type="text" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="e.g. Paracetamol">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small text-muted mb-1">Dosage</label>
                                            <input type="text" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="500mg">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted mb-1">Frequency</label>
                                            <input type="text" class="form-control form-control-sm rounded-1 border-0 shadow-none" placeholder="1x3">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger rounded-1 w-100 remove-item"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Additional Notes</label>
                                <textarea class="form-control rounded-1 border-light bg-light shadow-none" rows="3" placeholder="Special instructions..."></textarea>
                            </div>

                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-1 px-5 py-2 shadow-sm border-0 fw-bold">
                                    <i class="fa-solid fa-print me-2"></i> Save & Print
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
