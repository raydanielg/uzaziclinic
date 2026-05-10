@extends('layouts.app')

@section('content')
<div class="nurse-queue py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Waiting Queue</h4>
                <p class="text-muted small">Live status of patients waiting to see doctors.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0" id="queueTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Queue #</th>
                                    <th class="small text-uppercase fw-bold text-muted border-0">Patient</th>
                                    <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                                    <th class="small text-uppercase fw-bold text-muted border-0 text-center">Wait Time</th>
                                    <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($queue as $index => $item)
                                <tr>
                                    <td class="ps-4"><span class="h5 fw-bold text-primary">{{ $index + 1 }}</span></td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->user->name ?? 'N/A' }}</div>
                                        <div class="small text-muted">{{ $item->status == 'checked_in' ? 'Ready' : 'Waiting' }}</div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold text-dark">Dr. {{ $item->doctor->name ?? 'Any' }}</div>
                                    </td>
                                    <td class="text-center small text-muted">15 mins</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light rounded-1 border-0 text-success"><i class="fa-solid fa-bell me-1"></i> Call</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Queue is currently empty.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white mb-4">
                    <h6 class="small text-uppercase opacity-75 fw-bold mb-3 ls-1">Queue Summary</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $queue->count() }}</h2>
                            <p class="small mb-0 opacity-75">Total Waiting</p>
                        </div>
                        <i class="fa-solid fa-people-group fs-1 opacity-25"></i>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold mb-3 small text-uppercase ls-1">Estimated Wait Times</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                            <span class="text-muted">General Checkup</span>
                            <span class="fw-bold">~ 20 min</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2 border-light">
                            <span class="text-muted">Lab Collection</span>
                            <span class="fw-bold">~ 10 min</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#queueTable').DataTable({
        pageLength: 10,
        ordering: false,
        language: { search: "", searchPlaceholder: "Filter queue..." }
    });
});
</script>
@endpush
@endsection
