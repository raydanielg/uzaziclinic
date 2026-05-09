@extends('layouts.admin')

@section('page_title', 'All Appointments')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Management ya Miadi (Appointments)</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-calendar-plus me-2"></i>Weka Miadi Mpya
            </a>
        </div>
    </div>

    <!-- Filters/Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <a href="{{ route('admin.appointments.today') }}" class="card border-0 shadow-sm text-decoration-none transition-hover">
                <div class="card-body text-center">
                    <div class="icon-box bg-primary-soft text-primary mx-auto mb-2">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h6 class="text-muted mb-0">Leo</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.appointments.upcoming') }}" class="card border-0 shadow-sm text-decoration-none transition-hover">
                <div class="card-body text-center">
                    <div class="icon-box bg-success-soft text-success mx-auto mb-2">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h6 class="text-muted mb-0">Zinazokuja</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.appointments.history') }}" class="card border-0 shadow-sm text-decoration-none transition-hover">
                <div class="card-body text-center">
                    <div class="icon-box bg-info-soft text-info mx-auto mb-2">
                        <i class="fas fa-history"></i>
                    </div>
                    <h6 class="text-muted mb-0">Historia</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.appointments.cancelled') }}" class="card border-0 shadow-sm text-decoration-none transition-hover">
                <div class="card-body text-center">
                    <div class="icon-box bg-danger-soft text-danger mx-auto mb-2">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h6 class="text-muted mb-0">Zilizofutwa</h6>
                </div>
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
                            <th>Daktari</th>
                            <th>Tarehe na Muda</th>
                            <th>Hali (Status)</th>
                            <th class="text-end pe-4">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-soft text-primary rounded-circle me-3">
                                        {{ substr($appointment->patient->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $appointment->patient->name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $appointment->patient->phone ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</div>
                                <small class="text-muted text-capitalize">{{ $appointment->doctor->specialization ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $appointment->appointment_date->format('d M, Y') }}</div>
                                <small class="text-muted">{{ $appointment->appointment_date->format('h:i A') }}</small>
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning-soft text-warning',
                                        'confirmed' => 'bg-info-soft text-info',
                                        'completed' => 'bg-success-soft text-success',
                                        'cancelled' => 'bg-danger-soft text-danger',
                                    ][$appointment->status] ?? 'bg-secondary-soft text-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border shadow-none" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2 text-primary"></i>Angalia</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2 text-success"></i>Hariri</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Futa</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-calendar-minus fa-3x mb-3 opacity-20"></i>
                                    <p class="mb-0">Hakuna miadi iliyopatikana kwenye list hii.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($appointments->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $appointments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }

    .icon-box {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .avatar-sm {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .transition-hover {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
    }
</style>
@endsection
