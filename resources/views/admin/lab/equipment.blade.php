@extends('layouts.admin')

@section('page_title', 'Lab Equipment')

@section('content')
<div class="row animate__animated animate__fadeInUp mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Laboratory Equipment</h5>
                    <p class="text-muted small mb-0">Manage and track maintenance for lab instruments</p>
                </div>
                <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
                    <i class="fa-solid fa-plus me-2"></i> Register Equipment
                </button>
            </div>

            <div class="table-responsive">
                <table id="equipmentTable" class="table table-hover align-middle border-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-3 border-0">INSTRUMENT</th>
                            <th class="border-0">MODEL / SN</th>
                            <th class="border-0">LAST MAINTENANCE</th>
                            <th class="border-0">NEXT CALIBRATION</th>
                            <th class="border-0">STATUS</th>
                            <th class="text-end pe-3 border-0">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment as $item)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-microscope text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $item->name }}</span>
                                        <span class="text-muted extra-small">{{ $item->department ?? 'General' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark small">{{ $item->model ?? 'N/A' }}</div>
                                <span class="text-muted extra-small">SN: {{ $item->serial_number ?? '---' }}</span>
                            </td>
                            <td class="text-muted small">{{ $item->last_maintenance ? $item->last_maintenance->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-muted small">{{ $item->next_calibration ? $item->next_calibration->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $item->status_badge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Service Log">
                                        <i class="fa-solid fa-wrench text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-equipment" data-id="{{ $item->id }}" data-name="{{ $item->name }}" title="Delete">
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

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">Register New Equipment</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addEquipmentForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Equipment Name</label>
                            <input type="text" name="name" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. Centrifuge X1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Model Name</label>
                            <input type="text" name="model" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. Thermo Scientific">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control rounded-1 px-3 shadow-none border-light bg-light" placeholder="e.g. SN-123456">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Department</label>
                            <select name="department" class="form-select rounded-1 px-3 shadow-none border-light bg-light">
                                <option value="General">General Lab</option>
                                <option value="Hematology">Hematology</option>
                                <option value="Biochemistry">Biochemistry</option>
                                <option value="Microbiology">Microbiology</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Last Maintenance</label>
                            <input type="date" name="last_maintenance" class="form-control rounded-1 px-3 shadow-none border-light bg-light">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Next Calibration</label>
                            <input type="date" name="next_calibration" class="form-control rounded-1 px-3 shadow-none border-light bg-light">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Status</label>
                            <select name="status" class="form-select rounded-1 px-3 shadow-none border-light bg-light" required>
                                <option value="operational">Operational</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="out_of_order">Out of Order</option>
                                <option value="retired">Retired</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light rounded-1 px-4 me-2 border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                            <i class="fa-solid fa-check me-2"></i> Register Instrument
                        </button>
                    </div>
                </form>
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
        const equipmentTable = $('#equipmentTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search equipment...",
                emptyTable: "No equipment registered yet."
            }
        });

        // Register Equipment AJAX
        $('#addEquipmentForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.lab.equipment.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(resp) {
                    $('#addEquipmentModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Registered!', text: resp.message, timer: 1500, showConfirmButton: false })
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

        // Delete Equipment AJAX
        $(document).on('click', '.delete-equipment', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to remove ${name} from registry?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/lab/equipment') }}/${id}`,
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
@endpush
