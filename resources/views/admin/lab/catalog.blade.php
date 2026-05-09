@extends('layouts.admin')

@section('page_title', 'Lab Management')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-flask text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Total Tests</p>
                    <h4 class="fw-bold mb-0">{{ $stats['total'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-secondary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clock text-secondary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Pending</p>
                    <h4 class="fw-bold mb-0">{{ $stats['pending'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-spinner text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Processing</p>
                    <h4 class="fw-bold mb-0">{{ $stats['processing'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-check text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small">Completed</p>
                    <h4 class="fw-bold mb-0">{{ $stats['completed'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Laboratory Services</h5>
                <a href="#" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-flask-vial me-2"></i> New Test Request
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Test ID</th>
                            <th>Patient</th>
                            <th>Test Type</th>
                            <th>Lab Technician</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labTests ?? [] as $test)
                        <tr>
                            <td><span class="fw-bold text-primary">#LAB-{{ str_pad($test->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $test->patient?->user?->name ?? 'N/A' }}</td>
                            <td>{{ $test->test_name ?? $test->test_type ?? 'N/A' }}</td>
                            <td>{{ $test->technician?->name ?? 'Unassigned' }}</td>
                            <td><span class="badge {{ $test->status_badge }}">{{ ucfirst($test->status) }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-file-pdf"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-flask fs-1 mb-2 d-block"></i>
                                No lab tests found. Create your first test request.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $labTests->links() ?? '' }}
        </div>
    </div>
</div>
@endsection
