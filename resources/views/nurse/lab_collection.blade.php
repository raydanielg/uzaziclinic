@extends('layouts.app')

@section('content')
<div class="nurse-lab py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Lab Sample Collection</h4>
                <p class="text-muted small">Collect and record samples for laboratory testing.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="labTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Request Date</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Requested Tests</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Requested By</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending_samples as $sample)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $sample->created_at->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ $sample->created_at->format('H:i A') }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $sample->patient->name ?? 'N/A' }}</div>
                                <div class="small text-muted">ID: #PT-{{ $sample->patient->id }}</div>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary rounded-1">{{ $sample->test_names }}</span></td>
                            <td><span class="small fw-bold">Dr. {{ $sample->doctor->name ?? 'N/A' }}</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-primary rounded-1 px-4 fw-bold border-0 shadow-none">
                                    Collect Sample
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No pending samples to collect.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
