@extends('layouts.admin')

@section('page_title', 'Lab Results')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Lab Results (Majibu ya Maabara)</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Lab Results</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Test ID</th>
                            <th>Mgonjwa</th>
                            <th>Aina ya Kipimo</th>
                            <th>Muda</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labResults as $result)
                        <tr>
                            <td class="ps-4 fw-bold">#LAB-{{ str_pad($result->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $result->patient->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $result->test_name ?? 'N/A' }}</span></td>
                            <td>{{ $result->created_at->format('d M, Y H:i') }}</td>
                            <td>
                                @php
                                    $statusColor = $result->status == 'completed' ? 'success' : 'warning';
                                @endphp
                                <span class="badge bg-{{ $statusColor }}-soft text-{{ $statusColor }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $result->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-light border"><i class="fas fa-file-pdf me-1 text-danger"></i>Result</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-microscope fa-3x mb-3 opacity-20"></i>
                                <p class="mb-0">Hakuna majibu ya maabara kwa sasa.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($labResults->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $labResults->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
</style>
@endsection
