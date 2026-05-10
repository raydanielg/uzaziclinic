@extends('layouts.admin')

@section('page_title', 'Laboratory Catalog')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-flask text-primary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Total Tests</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['total'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-secondary-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-clock text-secondary fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Pending</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['pending'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-spinner text-warning fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Processing</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['processing'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle rounded-circle p-3 me-3">
                    <i class="fa-solid fa-check-double text-success fs-4"></i>
                </div>
                <div>
                    <p class="text-muted mb-0 small fw-bold text-uppercase">Completed</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ $stats['completed'] ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Lab Services Catalog</h5>
                    <p class="text-muted small mb-0">Track and manage all laboratory test requests</p>
                </div>
                <div class="d-flex gap-2">
                    <select id="filterType" class="form-select form-select-sm rounded-1 px-3 border-0 shadow-sm" style="width: 160px;">
                        <option value="">All Test Types</option>
                        @foreach($testTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <select id="filterStatus" class="form-select form-select-sm rounded-1 px-3 border-0 shadow-sm" style="width: 140px;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                    </select>
                    <button type="button" class="btn btn-primary rounded-1 px-4 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#newTestModal">
                        <i class="fa-solid fa-plus me-2"></i> New Request
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="labTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">TEST ID / DATE</th>
                            <th class="border-0">PATIENT</th>
                            <th class="border-0">TEST NAME / TYPE</th>
                            <th class="border-0">ASSIGNED STAFF</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="labTableBody">
                        @foreach($labTests ?? [] as $test)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-flask text-primary opacity-75"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block text-uppercase small ls-1">#LAB-{{ str_pad($test->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="text-muted extra-small">{{ $test->created_at->format('d M, Y') }}</span>
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
                                <div class="text-dark small">Dr. {{ $test->doctor->display_name ?? 'N/A' }}</div>
                                <div class="text-muted extra-small">Tech: {{ $test->technician?->name ?? 'Unassigned' }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $test->status_badge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ $test->status }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View">
                                        <i class="fa-solid fa-eye text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-test" 
                                            data-id="{{ $test->id }}" 
                                            title="Delete">
                                        <i class="fa-solid fa-trash text-danger small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- New Test Request Modal -->
<div class="modal fade" id="newTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Request New Lab Test</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="newTestForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Patient</label>
                            <select name="patient_id" class="form-select rounded-1 px-3 shadow-none border-light bg-light" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $p)
                                    <option value="{{ $p->id }}">{{ $p->display_name }} ({{ $p->patient_number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Requested By (Doctor)</label>
                            <select name="doctor_id" class="form-select rounded-1 px-3 shadow-none border-light bg-light" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $d)
                                    <option value="{{ $d->id }}">Dr. {{ $d->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Test Name</label>
                            <input type="text" name="test_name" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. Full Blood Count" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Test Category</label>
                            <select name="test_type" class="form-select rounded-1 px-3 shadow-none border-light bg-light" required>
                                <option value="">Select Category</option>
                                <option value="Hematology">Hematology</option>
                                <option value="Biochemistry">Biochemistry</option>
                                <option value="Microbiology">Microbiology</option>
                                <option value="Immunology">Immunology</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Estimated Cost (TZS)</label>
                            <input type="number" name="cost" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="0.00" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Clinical Notes</label>
                            <textarea name="notes" class="form-control rounded-1 px-3 shadow-none border-light bg-light" rows="3" placeholder="Reason for test..."></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light rounded-1 px-4 me-2 border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const labTable = $('#labTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            dom: 'rftip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search test ID or patient...",
                emptyTable: "No lab tests found matching your criteria."
            }
        });

        // AJAX Filtering
        function applyFilters() {
            const status = $('#filterStatus').val();
            const test_type = $('#filterType').val();

            $.ajax({
                url: "{{ route('admin.lab.catalog') }}",
                data: { status, test_type },
                success: function(html) {
                    labTable.destroy();
                    $('#labTableBody').html(html);
                    $('#labTable').DataTable({
                        responsive: true,
                        order: [[0, 'desc']],
                        dom: 'rftip',
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search test ID or patient...",
                            emptyTable: "No lab tests found matching your criteria."
                        }
                    });
                }
            });
        }

        $('#filterStatus, #filterType').on('change', applyFilters);

        // AJAX Creation
        $('#newTestForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Submitting...').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.lab.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(resp) {
                    $('#newTestModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success!', text: resp.message, timer: 1500, showConfirmButton: false })
                    .then(() => location.reload());
                },
                error: function(xhr) {
                    $btn.html(originalText).prop('disabled', false);
                    let msg = 'Something went wrong!';
                    if (xhr.status === 422) {
                        msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    Swal.fire('Error!', msg, 'error');
                }
            });
        });

        // AJAX Deletion
        $(document).on('click', '.delete-test', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/lab/catalog') }}/${id}`,
                        method: 'POST',
                        data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                        success: function(resp) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: resp.message, timer: 1500, showConfirmButton: false })
                            .then(() => location.reload());
                        }
                    });
                }
            });
        });
    });
</script>

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
    .form-select-sm { font-size: 0.75rem; height: 38px; }
    .dataTables_filter input {
        border-radius: 4px !important;
        padding: 8px 20px !important;
        border: 0 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05) !important;
        background: #fff !important;
        width: 250px !important;
    }
</style>
@endpush
