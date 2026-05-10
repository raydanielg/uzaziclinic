@extends('layouts.app')

@section('content')
<div class="nurse-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Nurse Dashboard</h1>
                <p class="text-muted small">Welcome back, {{ Auth::user()->name }}. Manage your patients and ward activities.</p>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-user-check fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Today's Patients</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['today_patients'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Waiting Queue</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['waiting_queue'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-bed-pulse fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Bed Occupancy</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['occupied_beds'] }}/{{ $stats['total_beds'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3">
                            <i class="fa-solid fa-flask fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Pending Labs</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_labs'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Patients -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-users me-2 text-primary"></i>Recently Registered</h5>
                        <a href="{{ route('nurse.patients') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3 border-0">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Phone</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Reg. Date</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_patients as $patient)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-3">
                                                    <i class="fa-solid fa-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                                    <div class="small text-muted">ID: #PT-{{ $patient->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="small text-dark fw-bold">{{ $patient->phone ?? 'N/A' }}</td>
                                        <td class="small text-muted">{{ $patient->created_at->format('M d, Y') }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('nurse.vitals') }}" class="btn btn-sm btn-outline-primary rounded-1 px-3 border-0 bg-primary-soft">
                                                Take Vitals
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No patients found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ward Overview -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="bg-dark p-4 text-white">
                        <h6 class="small text-uppercase opacity-75 fw-bold mb-3 ls-1">Ward Status</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="fw-bold mb-0">85% Occupied</h3>
                                <p class="small mb-0 opacity-75">Capacity: 45 Beds Total</p>
                            </div>
                            <i class="fa-solid fa-hospital-user fs-1 opacity-25"></i>
                        </div>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">General Ward</span>
                                <span class="small text-muted">18/20 Beds</span>
                            </div>
                            <div class="progress rounded-pill shadow-none" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 90%;"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">Maternity Ward</span>
                                <span class="small text-muted">12/15 Beds</span>
                            </div>
                            <div class="progress rounded-pill shadow-none" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: 80%;"></div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small fw-bold">Emergency / ICU</span>
                                <span class="small text-muted">4/10 Beds</span>
                            </div>
                            <div class="progress rounded-pill shadow-none" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 40%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Nurse Links -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Quick Tools</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('nurse.checkin') }}" class="btn btn-primary rounded-1 py-2 shadow-none border-0 text-start ps-3">
                            <i class="fa-solid fa-user-plus me-2"></i> Patient Check-in
                        </a>
                        <a href="{{ route('nurse.queue') }}" class="btn btn-warning rounded-1 py-2 shadow-none border-0 text-start ps-3 fw-bold">
                            <i class="fa-solid fa-list-ol me-2"></i> View Queue
                        </a>
                        <a href="{{ route('nurse.lab-collection') }}" class="btn btn-info text-white rounded-1 py-2 shadow-none border-0 text-start ps-3 fw-bold">
                            <i class="fa-solid fa-flask-vial me-2"></i> Sample Collection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
