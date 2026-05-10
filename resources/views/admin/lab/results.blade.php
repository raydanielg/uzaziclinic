@extends('layouts.admin')

@section('page_title', 'Lab Results')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Laboratory Results</h5>
                    <p class="text-muted small mb-0">View and manage completed lab test results</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.lab.catalog') }}" class="btn btn-light rounded-1 px-4 shadow-sm border">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Catalog
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="resultsTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">TEST ID / DATE</th>
                            <th class="border-0">PATIENT</th>
                            <th class="border-0">TEST NAME</th>
                            <th class="border-0">RESULT SUMMARY</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results ?? [] as $test)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success-subtle text-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-file-circle-check"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-uppercase small ls-1">#LAB-{{ str_pad($test->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $test->updated_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $test->patient->display_name ?? 'N/A' }}</div>
                                <div class="text-muted extra-small">{{ $test->patient->patient_number ?? '' }}</div>
                            </td>
                            <td>
                                <div class="text-dark fw-medium small">{{ $test->test_name }}</div>
                                <span class="badge bg-light text-primary border-0 small fw-normal">{{ $test->test_type }}</span>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 200px;">
                                    {{ $test->result ?? 'No summary provided' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    COMPLETED
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View Full Report">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Download PDF">
                                        <i class="fa-solid fa-file-pdf text-danger small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $results->links() ?? '' }}
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-sm { background-color: #f8fafc; }
    .table thead th {
        font-size: 0.7rem !important;
        letter-spacing: 1px;
        background: transparent !important;
        color: #94a3b8 !important;
        padding-bottom: 15px !important;
    }
    .btn-white { background: #fff; border: 1px solid #f1f5f9 !important; }
    .btn-white:hover { background: #f8fafc; }
    .ls-1 { letter-spacing: 0.5px; }
    .extra-small { font-size: 0.65rem; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#resultsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            dom: 'rftip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search results...",
                emptyTable: "No results found."
            }
        });
    });
</script>
@endpush
