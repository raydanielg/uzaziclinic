@extends('layouts.admin')

@section('page_title', 'Prescriptions')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Prescriptions (Vyeti vya Dawa)</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Prescriptions</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-2"></i>Andika Cheti Kipya
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Cheti ID</th>
                            <th>Mgonjwa</th>
                            <th>Daktari</th>
                            <th>Tarehe</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $prescription)
                        <tr>
                            <td class="ps-4 fw-bold">#RX-{{ str_pad($prescription->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="fw-bold">{{ $prescription->patient->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $prescription->patient->phone ?? '' }}</small>
                            </td>
                            <td>Dr. {{ $prescription->doctor->name ?? 'N/A' }}</td>
                            <td>{{ $prescription->created_at->format('d M, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $prescription->status == 'active' ? 'success' : 'secondary' }}-soft text-{{ $prescription->status == 'active' ? 'success' : 'secondary' }} rounded-pill px-3 py-2">
                                    {{ ucfirst($prescription->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border"><i class="fas fa-print me-1"></i>Print</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-file-prescription fa-3x mb-3 opacity-20"></i>
                                    <p class="mb-0">Hakuna vyeti vilivyopatikana.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
</style>
@endsection
