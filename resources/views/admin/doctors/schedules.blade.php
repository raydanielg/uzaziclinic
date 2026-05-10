@extends('layouts.admin')

@section('page_title', 'Doctor Schedules')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Doctor Schedules</h5>
                <button class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-calendar-plus me-2"></i> Set Schedule
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Doctor</th>
                            <th>Working Days</th>
                            <th>Available Time</th>
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
                                        <span class="fw-bold">{{ $doctor->display_name }}</span>
                                    </div>
                                </td>
                                <td>Mon, Tue, Wed, Thu, Fri</td>
                                <td>08:00 AM - 04:00 PM</td>
                                <td><span class="badge bg-success-subtle text-success">Available</span></td>
                                <td>
                                    <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-clock"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No schedules set yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
