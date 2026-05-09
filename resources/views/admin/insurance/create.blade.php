@extends('layouts.admin')

@section('page_title', 'Add Insurance')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Ongeza Bima ya Mgonjwa</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Chagua Mgonjwa</label>
                                <select name="patient_id" class="form-select" required>
                                    <option value="">-- Select Patient --</option>
                                    @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->phone }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kampuni ya Bima</label>
                                <select name="provider_name" class="form-select" required>
                                    <option value="NHIF">NHIF</option>
                                    <option value="Strategies">Strategies Insurance</option>
                                    <option value="Jubilee">Jubilee Insurance</option>
                                    <option value="Resolution">Resolution Insurance</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Namba ya Kadi</label>
                                <input type="text" name="card_number" class="form-control" placeholder="10-XXXXXXXX-X" required>
                            </div>
                            <div class="col-12 mt-4 text-end">
                                <hr>
                                <button type="submit" class="btn btn-danger px-5 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-save me-2"></i>Hifadhi Bima
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
