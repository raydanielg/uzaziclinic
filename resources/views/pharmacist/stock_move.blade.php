@extends('layouts.app')

@section('content')
<div class="pharmacist-stock-move py-4">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 text-success"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Stock In (Purchase)</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Select Medicine</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none">
                                @foreach($medicines as $med)
                                <option value="{{ $med->id }}">{{ $med->name }} (Current: {{ $med->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Quantity to Add</label>
                            <input type="number" class="form-control rounded-1 border-light bg-light shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Supplier</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none">
                                <option>General Supplier A</option>
                                <option>MedDistributor B</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-1 fw-bold border-0">Process Stock In</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Stock Out (Manual Adjustment)</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Select Medicine</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none">
                                @foreach($medicines as $med)
                                <option value="{{ $med->id }}">{{ $med->name }} (Current: {{ $med->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Quantity to Remove</label>
                            <input type="number" class="form-control rounded-1 border-light bg-light shadow-none">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Reason</label>
                            <select class="form-select rounded-1 border-light bg-light shadow-none">
                                <option>Damaged</option>
                                <option>Expired</option>
                                <option>Correction</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 rounded-1 fw-bold border-0">Process Stock Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
