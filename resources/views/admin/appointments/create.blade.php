@extends('layouts.admin')

@section('page_title', 'Book Appointment')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Weka Miadi Mpya</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
                    <li class="breadcrumb-item active">Book New</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.appointments.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Chagua Mgonjwa</label>
                                <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                    <option value="">-- Chagua Mgonjwa --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->phone }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Chagua Daktari</label>
                                <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">-- Chagua Daktari --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            Dr. {{ $doctor->name }} ({{ $doctor->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tarehe na Muda</label>
                                <input type="datetime-local" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Dalili (Symptoms)</label>
                                <textarea name="symptoms" class="form-control" rows="4" placeholder="Elezea dalili za mgonjwa hapa...">{{ old('symptoms') }}</textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-check-circle me-2"></i>Thibitisha Miadi
                                </button>
                                <a href="{{ route('admin.appointments.index') }}" class="btn btn-light px-5 py-2 rounded-pill fw-bold ms-2">Ghairi</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Maelekezo</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-3">
                            <strong>1. Chagua Mgonjwa:</strong> Hakikisha mgonjwa ameshasajiliwa kwenye mfumo.
                        </li>
                        <li class="mb-3">
                            <strong>2. Chagua Daktari:</strong> Chagua daktari bingwa anayehusika na tatizo la mgonjwa.
                        </li>
                        <li class="mb-3">
                            <strong>3. Muda:</strong> Muda wa miadi unapaswa kuwa wa mbeleni, si wa nyuma.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
