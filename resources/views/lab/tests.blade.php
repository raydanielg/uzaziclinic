@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Lab Tests Catalog</h1>
                <p class="text-muted small mb-0">All available laboratory tests and their configurations.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#addTestModal">
                    <i class="fa-solid fa-plus me-2"></i>Add Test
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-vial-circle-check me-2 text-primary"></i>All Tests ({{ $tests->count() }})</h5>
                <div class="input-group" style="max-width:260px;">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Search test...">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="testsTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">#</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Test Name</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Category</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Sample Type</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Price (TZS)</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Turnaround</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $test->name }}</td>
                                <td class="small text-muted">{{ $test->category ?? 'General' }}</td>
                                <td class="small text-muted">{{ $test->sample_type ?? 'Blood' }}</td>
                                <td class="fw-bold text-success">{{ number_format($test->price ?? 0) }}</td>
                                <td class="small text-muted">{{ $test->turnaround_time ?? '24 hrs' }}</td>
                                <td>
                                    <span class="badge bg-{{ $test->status === 'active' ? 'success' : 'secondary' }}-subtle 
                                        text-{{ $test->status === 'active' ? 'success' : 'secondary' }} rounded-pill">
                                        {{ ucfirst($test->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-secondary rounded-2">Edit</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-vial fs-2 d-block mb-2 opacity-25"></i>
                                    No tests in catalog. Add your first test.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Test Modal -->
<div class="modal fade" id="addTestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-vial me-2"></i>Add Lab Test</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Test Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Complete Blood Count (CBC)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Category</label>
                        <select class="form-select">
                            <option>Hematology</option>
                            <option>Biochemistry</option>
                            <option>Microbiology</option>
                            <option>Serology</option>
                            <option>Urinalysis</option>
                            <option>Parasitology</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sample Type</label>
                        <select class="form-select">
                            <option>Blood</option>
                            <option>Urine</option>
                            <option>Stool</option>
                            <option>Sputum</option>
                            <option>Swab</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Price (TZS)</label>
                        <input type="number" class="form-control" placeholder="5000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Turnaround Time</label>
                        <input type="text" class="form-control" placeholder="e.g. 2 hours">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Normal Range / Reference</label>
                        <textarea class="form-control" rows="2" placeholder="Normal values and reference ranges..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4"><i class="fa-solid fa-save me-2"></i>Save Test</button>
            </div>
        </div>
    </div>
</div>
@endsection
