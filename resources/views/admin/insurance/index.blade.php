@extends('layouts.admin')

@section('page_title', 'Insurance Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Insurance Info (Bima za Afya)</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Insurance</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.insurance.create') }}" class="btn btn-danger shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-2"></i>Ongeza Bima ya Mteja
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mgonjwa</th>
                            <th>Kampuni ya Bima</th>
                            <th>Card Number</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($insurances as $insurance)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $insurance->patient->name ?? 'N/A' }}</td>
                            <td>{{ $insurance->provider_name ?? 'N/A' }}</td>
                            <td><code>{{ $insurance->card_number ?? 'N/A' }}</code></td>
                            <td>
                                <span class="badge bg-success-soft text-success rounded-pill px-3 py-2">Active</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border shadow-none"><i class="fas fa-edit me-1"></i>Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-shield-heart fa-3x mb-3 opacity-20"></i>
                                <p class="mb-0">Hakuna kumbukumbu za bima zilizopatikana.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($insurances->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $insurances->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
</style>
@endsection
