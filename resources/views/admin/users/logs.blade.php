@extends('layouts.admin')

@section('page_title', 'Activity Logs')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="fw-bold mb-0">System Activity Logs</h5>
                            <p class="text-muted small mb-0">Monitor all system actions, changes, and security events</p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-light btn-sm border" onclick="window.location.reload()">
                                <i class="fa-solid fa-rotate me-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table id="logsTable" class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-2">TIME</th>
                                    <th>USER</th>
                                    <th>ACTION</th>
                                    <th>MODULE / TARGET</th>
                                    <th>IP ADDRESS</th>
                                    <th class="text-end pe-2">DETAILS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs ?? [] as $log)
                                <tr>
                                    <td class="ps-2">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark small">{{ optional($log->created_at)->format('d M, Y') }}</span>
                                            <span class="text-muted" style="font-size: 0.7rem;">{{ optional($log->created_at)->format('H:i:s') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ substr($log->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div class="fw-medium text-dark small">{{ $log->user->name ?? 'System' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $action = strtolower($log->action);
                                            $badgeClass = 'bg-secondary-subtle text-secondary';
                                            if(str_contains($action, 'create') || str_contains($action, 'add')) $badgeClass = 'bg-success-subtle text-success border-success-subtle';
                                            elseif(str_contains($action, 'update') || str_contains($action, 'edit')) $badgeClass = 'bg-info-subtle text-info border-info-subtle';
                                            elseif(str_contains($action, 'delete') || str_contains($action, 'remove')) $badgeClass = 'bg-danger-subtle text-danger border-danger-subtle';
                                            elseif(str_contains($action, 'login')) $badgeClass = 'bg-primary-subtle text-primary border-primary-subtle';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} border px-2 py-1 fw-normal text-uppercase" style="font-size: 0.65rem;">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark small fw-medium">{{ $log->auditable_type ? class_basename($log->auditable_type) : 'General' }}</span>
                                            <span class="text-muted" style="font-size: 0.7rem;">ID: #{{ $log->auditable_id ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted small">
                                        <code class="text-secondary bg-light px-1 rounded">{{ $log->ip_address ?? '127.0.0.1' }}</code>
                                    </td>
                                    <td class="text-end pe-2">
                                        <button class="btn btn-sm btn-light border-0 rounded-circle" onclick="viewLogDetails({{ $log->id }})">
                                            <i class="fa-solid fa-circle-info text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#logsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"lBf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa-solid fa-file-pdf me-1"></i> PDF',
                    className: 'btn btn-outline-danger btn-sm px-3',
                    title: 'System Activity Logs',
                    exportOptions: { columns: [0, 1, 2, 3, 4] }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-file-excel me-1"></i> Excel',
                    className: 'btn btn-outline-success btn-sm px-3',
                    title: 'System Activity Logs'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Filter logs...",
                lengthMenu: "Show _MENU_"
            }
        });
    });

    function viewLogDetails(id) {
        Swal.fire({
            title: 'Log Details',
            text: 'Detailed view for Log #' + id + ' will be shown here.',
            icon: 'info',
            confirmButtonColor: '#6366f1'
        });
    }
</script>
@endpush

<style>
    .table thead th {
        font-size: 0.75rem !important;
        letter-spacing: 0.5px;
        background: #f8fafc !important;
        color: #64748b !important;
        border-bottom: 2px solid #e2e8f0 !important;
        text-transform: uppercase;
    }
    .dataTables_filter input {
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        padding: 0.3rem 0.75rem;
        outline: none;
    }
    .badge {
        letter-spacing: 0.3px;
    }
</style>
@endsection
