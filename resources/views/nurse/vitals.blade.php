@extends('layouts.app')

@section('content')
<div class="nurse-vitals py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden position-relative">
                    <div class="position-absolute end-0 top-0 p-4 opacity-10">
                        <i class="fa-solid fa-heart-pulse fa-6x"></i>
                    </div>
                    <div class="position-relative">
                        <h4 class="fw-bold mb-1 text-primary">Record Vitals</h4>
                        <p class="text-muted small mb-4">Input patient vital signs for medical assessment.</p>
                    </div>

                    <form>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Select Patient</label>
                                <select class="form-select rounded-1 border-light bg-light shadow-none py-2" required>
                                    <option value="">Choose a patient...</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }} (#PT-{{ $patient->id }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Temperature (°C)</label>
                                <input type="number" step="0.1" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 36.5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Blood Pressure (mmHg)</label>
                                <input type="text" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 120/80">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Heart Rate (bpm)</label>
                                <input type="number" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 72">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Respiratory Rate (breaths/min)</label>
                                <input type="number" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 16">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Weight (kg)</label>
                                <input type="number" step="0.1" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 65.5">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Height (cm)</label>
                                <input type="number" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. 170">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Other Observations</label>
                                <textarea class="form-control rounded-1 border-light bg-light shadow-none" rows="3" placeholder="Notes about patient condition..."></textarea>
                            </div>

                            <div class="col-md-12 text-end pt-3 border-top">
                                <button type="submit" class="btn btn-primary rounded-1 px-5 py-2 shadow-sm border-0 fw-bold">
                                    Save Vitals
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
