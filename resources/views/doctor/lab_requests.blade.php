@extends('layouts.app')

@section('content')
<div class="doctor-lab py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Lab Requests & Results</h4>
                <p class="text-muted small">Track your lab test orders and review patient results</p>
            </div>
            <button class="btn btn-warning rounded-1 px-4 shadow-sm border-0 fw-bold">
                <i class="fa-solid fa-flask me-2"></i> New Lab Request
            </button>
        </div>

        <div class="row g-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <ul class="nav nav-pills mb-4 bg-light p-1 rounded-1" id="pills-tab" role="tablist">
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link active rounded-1 small fw-bold text-uppercase py-2" id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button" role="tab">Pending Requests</button>
                        </li>
                        <li class="nav-item flex-fill text-center" role="presentation">
                            <button class="nav-link rounded-1 small fw-bold text-uppercase py-2" id="pills-results-tab" data-bs-toggle="pill" data-bs-target="#pills-results" type="button" role="tab">Lab Results</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Date</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Test Type</th>
                                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4">May 10, 2026</td>
                                            <td class="fw-bold">Jane Cooper</td>
                                            <td>Full Blood Count</td>
                                            <td><span class="badge bg-warning-subtle text-warning rounded-pill px-3">Processing</span></td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-light rounded-1 text-danger border-0"><i class="fa-solid fa-xmark me-1"></i> Cancel</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-results" role="tabpanel">
                            <!-- Results Table -->
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-vial-circle-check fs-1 opacity-25 mb-3 d-block"></i>
                                Select a record to view results.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
