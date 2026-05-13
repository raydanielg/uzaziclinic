@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h1 class="h3 mb-0 fw-bold">Lab Equipment</h1>
                <p class="text-muted small mb-0">Manage laboratory equipment inventory and maintenance schedules.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary rounded-2" data-bs-toggle="modal" data-bs-target="#addEquipModal">
                    <i class="fa-solid fa-plus me-2"></i>Add Equipment
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-microscope me-2 text-primary"></i>Equipment Inventory</h5>
                <div class="input-group" style="max-width:260px;">
                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Search equipment...">
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="equipTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 small fw-bold text-muted text-uppercase border-0">#</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Equipment Name</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Model</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Serial No.</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Last Service</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Next Service</th>
                                <th class="small fw-bold text-muted text-uppercase border-0">Status</th>
                                <th class="text-end pe-4 small fw-bold text-muted text-uppercase border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equipment as $equip)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $equip->name }}</td>
                                <td class="small text-muted">{{ $equip->model ?? 'N/A' }}</td>
                                <td class="small text-muted">{{ $equip->serial_number ?? 'N/A' }}</td>
                                <td class="small text-muted">{{ optional($equip->last_service_date)->format('d M Y') ?? 'N/A' }}</td>
                                <td class="small text-muted">{{ optional($equip->next_service_date)->format('d M Y') ?? 'N/A' }}</td>
                                <td>
                                    @php $st = $equip->status ?? 'operational'; @endphp
                                    <span class="badge bg-{{ $st === 'operational' ? 'success' : ($st === 'maintenance' ? 'warning' : 'danger') }}-subtle 
                                        text-{{ $st === 'operational' ? 'success' : ($st === 'maintenance' ? 'warning' : 'danger') }} rounded-pill">
                                        {{ ucfirst($st) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-secondary rounded-2">Edit</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-microscope fs-2 d-block mb-2 opacity-25"></i>
                                    No equipment records found.
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

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-microscope me-2"></i>Add Equipment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Equipment Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Centrifuge Machine">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Model</label>
                        <input type="text" class="form-control" placeholder="Model number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Serial Number</label>
                        <input type="text" class="form-control" placeholder="Serial no.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Last Service Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Next Service Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Status</label>
                        <select class="form-select">
                            <option value="operational">Operational</option>
                            <option value="maintenance">Under Maintenance</option>
                            <option value="faulty">Faulty</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4"><i class="fa-solid fa-save me-2"></i>Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
