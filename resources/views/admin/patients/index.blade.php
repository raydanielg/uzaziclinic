@extends('layouts.admin')

@section('page_title', 'All Patients')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Patient Registry</h5>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-plus me-2"></i> Register Patient
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Last Visit</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td><span class="fw-bold text-primary">#PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <div class="fw-bold">{{ $patient->user->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $patient->user->email ?? '' }}</div>
                                </td>
                                <td class="text-muted">{{ optional($patient->updated_at)->format('d M, Y') }}</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                                    <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
