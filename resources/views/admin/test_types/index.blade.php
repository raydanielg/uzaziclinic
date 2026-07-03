@extends('layouts.admin')

@section('page_title', 'Test Types')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4 align-items-center animate__animated animate__fadeIn">
        <div class="col">
            <h4 class="fw-bold mb-1">Lab Test Types</h4>
            <p class="text-muted small mb-0">Manage laboratory test types, categories and pricing</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary px-4 shadow-sm rounded-3" onclick="showCreateModal()">
                <i class="fa-solid fa-plus me-2"></i> Create Test Type
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle text-primary rounded-3 p-3">
                        <i class="fa-solid fa-flask fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Test Types</div>
                        <div class="fw-bold fs-5">{{ $testTypes->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success-subtle text-success rounded-3 p-3">
                        <i class="fa-solid fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Active</div>
                        <div class="fw-bold fs-5">{{ $testTypes->where('status', 'active')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning-subtle text-warning rounded-3 p-3">
                        <i class="fa-solid fa-layer-group fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Categories</div>
                        <div class="fw-bold fs-5">{{ $categories->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 animate__animated animate__fadeInUp">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0" id="testTypesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Category</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Price</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Turnaround</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Status</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testTypes as $type)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $type->name }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 240px;">{{ $type->description ?? 'No description' }}</div>
                            </td>
                            <td><span class="badge bg-light text-dark border rounded-pill px-3">{{ $type->category ?? 'Uncategorized' }}</span></td>
                            <td class="fw-bold small">TZS {{ number_format($type->price, 2) }}</td>
                            <td class="small text-muted">{{ $type->turnaround_time ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $type->status_badge }} rounded-pill px-3">{{ ucfirst($type->status) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-2 border-0 me-1" onclick="showEditModal({{ $type->id }})" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </button>
                                <form action="{{ route('admin.test-types.destroy', $type) }}" method="POST" class="d-inline delete-form" data-name="{{ $type->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-2 border-0" title="Delete">
                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTestTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.test-types.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-flask me-2"></i>Create Test Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Name</label>
                            <input type="text" name="name" class="form-control rounded-2 border-light bg-light shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                            <input type="text" name="category" class="form-control rounded-2 border-light bg-light shadow-none" list="categoryList" placeholder="e.g. Blood">
                            <datalist id="categoryList">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Price (TZS)</label>
                            <input type="number" name="price" step="0.01" min="0" class="form-control rounded-2 border-light bg-light shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Turnaround Time</label>
                            <input type="text" name="turnaround_time" class="form-control rounded-2 border-light bg-light shadow-none" placeholder="e.g. 24 hours">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                            <select name="status" class="form-select rounded-2 border-light bg-light shadow-none" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Description</label>
                            <textarea name="description" class="form-control rounded-2 border-light bg-light shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-2 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4 fw-bold">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTestTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form id="editTestTypeForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Test Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Name</label>
                            <input type="text" name="name" id="editName" class="form-control rounded-2 border-light bg-light shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                            <input type="text" name="category" id="editCategory" class="form-control rounded-2 border-light bg-light shadow-none" list="categoryList" placeholder="e.g. Blood">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Price (TZS)</label>
                            <input type="number" name="price" id="editPrice" step="0.01" min="0" class="form-control rounded-2 border-light bg-light shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Turnaround Time</label>
                            <input type="text" name="turnaround_time" id="editTurnaround" class="form-control rounded-2 border-light bg-light shadow-none" placeholder="e.g. 24 hours">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                            <select name="status" id="editStatus" class="form-select rounded-2 border-light bg-light shadow-none" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Description</label>
                            <textarea name="description" id="editDescription" class="form-control rounded-2 border-light bg-light shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-2 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-2 px-4 fw-bold">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const testTypes = @json($testTypes);

$(document).ready(function() {
    $('#testTypesTable').DataTable({
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search test types...",
            emptyTable: "No test types found.",
            zeroRecords: "No matching test types found."
        }
    });

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        const name = $(form).data('name');
        Swal.fire({
            title: 'Delete Test Type?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

function showCreateModal() {
    const modal = new bootstrap.Modal(document.getElementById('createTestTypeModal'));
    modal.show();
}

function showEditModal(id) {
    const type = testTypes.find(t => t.id === id);
    if (!type) return;

    document.getElementById('editTestTypeForm').action = `/admin/test-types/${id}`;
    document.getElementById('editName').value = type.name;
    document.getElementById('editCategory').value = type.category || '';
    document.getElementById('editPrice').value = type.price;
    document.getElementById('editTurnaround').value = type.turnaround_time || '';
    document.getElementById('editStatus').value = type.status;
    document.getElementById('editDescription').value = type.description || '';

    const modal = new bootstrap.Modal(document.getElementById('editTestTypeModal'));
    modal.show();
}

@if(session('success'))
    Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
@endif
@if(session('error'))
    Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
@endif
</script>
@endpush

<style>
    .form-check-input:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }
</style>
@endsection
