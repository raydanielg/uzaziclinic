@extends('layouts.admin')

@section('page_title', 'Doctor Performance Reports')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-md text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Doctors</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $totalDoctors ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-user-check text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Active Now</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $activeDoctors ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-1 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-info-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-calendar-check text-info fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Monthly Consults</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $doctors->sum('appointments_count') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Consultation Performance</h5>
                    <p class="text-muted small mb-0">Monthly appointments handled per doctor</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light rounded-1 px-3 border shadow-sm small">
                        <i class="fa-solid fa-download me-2"></i> Export Data
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="doctorTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">DOCTOR NAME</th>
                            <th class="border-0">SPECIALIZATION</th>
                            <th class="border-0">APPOINTMENTS (MO)</th>
                            <th class="border-0">AVAILABILITY</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-1 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-user-md text-primary opacity-75 small"></i>
                                    </div>
                                    <span class="fw-bold text-dark small">Dr. {{ $doctor->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border-0 rounded-1 px-2 py-1 fw-normal">{{ $doctor->specialization ?? 'General' }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="fw-bold text-dark me-2 small">{{ $doctor->appointments_count }}</div>
                                    <div class="progress flex-grow-1" style="height: 4px; max-width: 100px;">
                                        @php $max = $doctors->max('appointments_count') ?: 1; @endphp
                                        <div class="progress-bar bg-success" style="width: {{ ($doctor->appointments_count / $max) * 100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $doctor->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $doctor->status }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Full Stats">
                                    <i class="fa-solid fa-chart-simple text-primary small"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                            <td colspan="4" class="text-center text-muted py-4">No doctors found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
