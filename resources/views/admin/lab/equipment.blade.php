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
                <button class="btn btn-primary rounded-1 px-4 shadow-sm border-0">
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
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-microscope text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block">Compound Microscope</span>
                                        <span class="text-muted extra-small">Microbiology Dept</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark small">Opti-X 500</div>
                                <span class="text-muted extra-small">SN: 2026-X892</span>
                            </td>
                            <td class="text-muted small">Apr 15, 2026</td>
                            <td class="text-muted small">Oct 15, 2026</td>
                            <td>
                                <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">Operational</span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group shadow-sm rounded-1 overflow-hidden">
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Service Log">
                                        <i class="fa-solid fa-wrench text-primary small"></i>
                                    </button>
                                    <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Edit">
                                        <i class="fa-solid fa-pen text-secondary small"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
        $('#equipmentTable').DataTable({
            responsive: true,
            dom: 'rtip',
            language: {
                emptyTable: "No equipment registered yet."
            }
        });
    });
</script>
@endpush
