@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-2"></i>Services Management</h4>
            <p class="text-muted small mb-0">Manage clinic services and pricing</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-plus me-2"></i>Add Service
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price (TZS)</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $service->name }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">{{ $service->description ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-success">{{ number_format($service->price, 2) }}</div>
                            </td>
                            <td>
                                @if($service->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-light rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-2" onclick="return confirm('Are you sure you want to delete this service?')" title="Delete">
                                            <i class="fa-solid fa-trash text-rose"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-list-slash fs-2 opacity-25 d-block mb-2"></i>
                                No services found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
