@extends('layouts.app')

@section('content')
<div class="pharmacist-dispense py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('pharmacist.prescriptions') }}" class="btn btn-light rounded-1 px-3 border-0 text-muted small mb-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                </a>
                <h4 class="fw-bold mb-0 text-dark">Dispense Medicines</h4>
                <p class="text-muted small">Confirm and dispense the prescribed medicines for patient assessment.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Patient & Doctor Info -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Patient Info</h6>
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary-soft text-primary rounded-circle p-3 me-3">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">{{ $prescription->patient->name ?? 'N/A' }}</h5>
                            <small class="text-muted">#PT-{{ $prescription->patient_id }} | {{ $prescription->patient->phone ?? 'No Phone' }}</small>
                        </div>
                    </div>
                    <hr class="border-light opacity-50">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1 mt-4">Prescribed By</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success rounded-circle p-3 me-3">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Dr. {{ $prescription->doctor->name ?? 'N/A' }}</h5>
                            <small class="text-muted">Specialist Doctor</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-dark text-white">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1 opacity-75">Billing Summary</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small opacity-75">Subtotal</span>
                        <span class="fw-bold">TZS 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="small opacity-75">Discount</span>
                        <span class="fw-bold">TZS 0</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Payable</span>
                        <h4 class="fw-bold mb-0 text-success">TZS 0</h4>
                    </div>
                </div>
            </div>

            <!-- Medicine List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-4">Prescribed Medicines</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-4 border-0">Medicine</th>
                                    <th class="border-0">Dosage</th>
                                    <th class="border-0">Duration</th>
                                    <th class="border-0">Instock</th>
                                    <th class="text-end pe-4 border-0">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->medicine->name ?? 'Unknown Medicine' }}</div>
                                        <div class="small text-muted">{{ $item->medicine->category ?? 'General' }}</div>
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3 fw-bold">{{ $item->dosage }}</span></td>
                                    <td class="small">{{ $item->duration }}</td>
                                    <td>
                                        <span class="fw-bold {{ ($item->medicine->stock ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $item->medicine->stock ?? 0 }} {{ $item->medicine->unit ?? 'pcs' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 pt-4 border-top text-end">
                        <button class="btn btn-light rounded-1 px-4 border-0 fw-bold me-2">Print Receipt</button>
                        <button class="btn btn-success rounded-1 px-5 py-2 fw-bold border-0 shadow-sm">Confirm & Dispense</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
