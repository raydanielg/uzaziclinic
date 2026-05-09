@extends('layouts.admin')

@section('page_title', 'Medical Records')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Medical Records (Kumbukumbu za Matibabu)</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Medical Records</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold">Orodha ya Wagonjwa na Kumbukumbu</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" class="form-control border-end-0 shadow-none" placeholder="Tafuta mgonjwa...">
                        <span class="input-group-text bg-white border-start-0 text-muted"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mgonjwa</th>
                            <th>Jinsia</th>
                            <th>Miadi (Total)</th>
                            <th>Vyeti (Rx)</th>
                            <th>Last Visit</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-primary">{{ $patient->name }}</div>
                                <small class="text-muted">{{ $patient->phone }}</small>
                            </td>
                            <td class="text-capitalize">{{ $patient->gender ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary-soft text-primary">{{ $patient->appointments_count }}</span></td>
                            <td><span class="badge bg-success-soft text-success">{{ $patient->prescriptions_count }}</span></td>
                            <td>{{ $patient->updated_at->format('d M, Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-folder-open me-1"></i>Open Files</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Hakuna kumbukumbu zilizopatikana.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($patients->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
</style>
@endsection
