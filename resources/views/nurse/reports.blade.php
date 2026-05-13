@extends('layouts.app')

@section('content')
<div class="nurse-reports py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Nursing Reports</h1>
                <p class="text-muted small mb-0">Daily task summary, patient care records and shift reports.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary rounded-2 me-2" onclick="window.print()">
                    <i class="fa-solid fa-print me-2"></i>Print
                </button>
                <button class="btn btn-primary rounded-2">
                    <i class="fa-solid fa-file-export me-2"></i>Export
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3"><i class="fa-solid fa-user-check fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Patients Attended</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3"><i class="fa-solid fa-pills fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Medications Given</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3"><i class="fa-solid fa-vial fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Samples Collected</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-soft text-warning p-3 rounded-4 me-3"><i class="fa-solid fa-heart-pulse fs-4"></i></div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold text-uppercase">Vitals Recorded</p>
                            <h3 class="mb-0 fw-bold">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Daily Report Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-clipboard-list me-2 text-primary"></i>Daily Activity Log</h5>
                        <input type="date" class="form-control form-control-sm" style="max-width: 160px;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 small fw-bold text-muted text-uppercase border-0">Time</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Activity</th>
                                        <th class="small fw-bold text-muted text-uppercase border-0">Patient</th>
                                        <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-clipboard fs-2 d-block mb-2 opacity-25"></i>
                                            No activities recorded for today.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shift Report -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-moon me-2 text-warning"></i>Shift Handover</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Outgoing Nurse</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Handover Notes</label>
                            <textarea class="form-control" rows="4" placeholder="Write important patient notes for next shift..."></textarea>
                        </div>
                        <button class="btn btn-primary w-100 rounded-2">
                            <i class="fa-solid fa-paper-plane me-2"></i>Submit Handover
                        </button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-chart-pie me-2 text-success"></i>This Week</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="weeklyChart" height="180"></canvas>
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
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('weeklyChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Patients',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: '#0d6efd',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }
</script>
@endpush
@endsection
