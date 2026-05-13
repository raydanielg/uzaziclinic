@extends('layouts.app')

@section('content')
<div class="patient-dashboard py-4">
    <div class="container-fluid">

        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="h4 mb-1 fw-bold text-white">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                            <p class="text-white mb-0 opacity-75">Patient ID: <strong>#PT-{{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</strong> &nbsp;|&nbsp; {{ now()->format('l, d F Y') }}</p>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            <i class="fa-solid fa-hospital-user text-white opacity-25" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3"><i class="fa-solid fa-calendar-check fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Appointments</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3"><i class="fa-solid fa-file-prescription fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Prescriptions</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3"><i class="fa-solid fa-flask-vial fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Lab Results</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3"><i class="fa-solid fa-file-invoice-dollar fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Pending Bills</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">

                <!-- Upcoming Appointments -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Upcoming Appointments</h5>
                        <a href="#" class="btn btn-sm btn-primary rounded-2">
                            <i class="fa-solid fa-plus me-1"></i>Book New
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small fw-bold text-muted text-uppercase border-0">Doctor</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Date & Time</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Type</th>
                                        <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-calendar-xmark d-block mb-2 fs-3 opacity-25"></i>
                                            No upcoming appointments. <a href="#">Book one now</a>.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Active Prescriptions -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-prescription me-2 text-success"></i>Active Prescriptions</h5>
                        <a href="#" class="btn btn-sm btn-light text-success fw-bold border-0">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small fw-bold text-muted text-uppercase border-0">Medicine</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Dosage</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Frequency</th>
                                        <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-pills d-block mb-2 fs-3 opacity-25"></i>
                                            No active prescriptions.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Panel -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 text-center p-4">
                    <div class="bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="width:80px;height:80px;font-size:2rem;">
                        <i class="fa-solid fa-user-injured"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-1">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Patient</span>
                    <div class="d-grid mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-2">
                            <i class="fa-solid fa-pen me-1"></i>Edit Profile
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3 small text-uppercase text-muted">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary rounded-2 text-start ps-3">
                                <i class="fa-solid fa-calendar-plus me-2"></i>Book Appointment
                            </a>
                            <a href="#" class="btn btn-outline-success rounded-2 text-start ps-3">
                                <i class="fa-solid fa-file-prescription me-2"></i>View Prescriptions
                            </a>
                            <a href="#" class="btn btn-outline-info rounded-2 text-start ps-3">
                                <i class="fa-solid fa-flask-vial me-2"></i>Lab Results
                            </a>
                            <a href="#" class="btn btn-outline-warning rounded-2 text-start ps-3">
                                <i class="fa-solid fa-receipt me-2"></i>My Bills
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Health Tip -->
                <div class="card border-0 rounded-4 p-3" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-heart-pulse me-2"></i>Health Tip</h6>
                    <p class="small text-success mb-0">Remember to take your medications on time and attend all your scheduled appointments for the best health outcomes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.15); }
</style>
@endsection
