@extends('layouts.app')

@section('content')
<div class="doctor-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Doctor Dashboard</h1>
                <p class="text-muted">Karibu Daktari {{ Auth::user()->name }}. Hapa kuna muhtasari wa wagonjwa na miadi yako.</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-calendar-check fa-2xl"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Miadi ya Leo</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-hospital-user fa-2xl"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Jumla ya Wagonjwa</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3">
                            <i class="fa-solid fa-clock-rotate-left fa-2xl"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Inayosubiri (Pending)</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_reviews'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Miadi ya Karibuni (Recent Appointments)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Mgonjwa</th>
                                        <th>Muda</th>
                                        <th>Hali (Status)</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center py-5">
                                        <td colspan="4" class="text-muted py-5">Hakuna miadi kwa sasa.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
</style>
@endsection
