@extends('layouts.admin')

@section('page_title', 'All Doctors')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Doctor Directory</h5>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i> Add Doctor
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Doctor</th>
                            <th>Specialization</th>
                            <th>License</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">DR</div>
                                        <span class="fw-bold">{{ $doctor->user->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="text-muted small">{{ $doctor->user->email ?? '' }}</div>
                                </td>
                                <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                                <td class="text-muted">{{ $doctor->license_number ?? 'N/A' }}</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-pen"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No doctors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>

 @if(isset($doctorUsersMissingProfile) && $doctorUsersMissingProfile->count())
 <div class="row animate__animated animate__fadeInUp mt-4">
     <div class="col-12">
         <div class="card border-0 shadow-sm rounded-4 p-4">
             <div class="d-flex justify-content-between align-items-center mb-3">
                 <div>
                     <h5 class="fw-bold mb-0">Doctor Users Missing Profile</h5>
                     <div class="text-muted small">These users have role Doctor but no doctor profile record yet.</div>
                 </div>
             </div>
             <div class="table-responsive">
                 <table class="table table-hover align-middle">
                     <thead class="bg-light text-muted">
                         <tr>
                             <th>User</th>
                             <th>Email</th>
                             <th>Phone</th>
                             <th>Status</th>
                             <th class="text-end">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach($doctorUsersMissingProfile as $u)
                         <tr>
                             <td class="fw-bold">{{ $u->name }}</td>
                             <td class="text-muted">{{ $u->email }}</td>
                             <td class="text-muted">{{ $u->phone ?? '---' }}</td>
                             <td>
                                 <span class="badge {{ ($u->status ?? 'active') === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                     {{ ucfirst($u->status ?? 'active') }}
                                 </span>
                             </td>
                             <td class="text-end">
                                 <form action="{{ route('admin.doctors.from-user', $u->id) }}" method="POST" class="d-inline">
                                     @csrf
                                     <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                         <i class="fa-solid fa-user-plus me-1"></i> Create Profile
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
 @endif
@endsection
