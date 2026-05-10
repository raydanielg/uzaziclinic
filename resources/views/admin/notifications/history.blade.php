@extends('admin.notifications.layout')

@section('notification_title', 'Broadcast History')
@section('notification_subtitle', 'Review all previously sent communications')

@section('notification_content')
<div class="table-responsive">
    <table class="table table-hover align-middle border-0" id="historyTable">
        <thead class="bg-light">
            <tr>
                <th class="border-0 small text-uppercase fw-bold text-muted ps-4">Date & Time</th>
                <th class="border-0 small text-uppercase fw-bold text-muted">Recipients</th>
                <th class="border-0 small text-uppercase fw-bold text-muted">Channels</th>
                <th class="border-0 small text-uppercase fw-bold text-muted">Title</th>
                <th class="border-0 small text-uppercase fw-bold text-muted text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ps-4">
                    <div class="fw-bold mb-0">May 10, 2026</div>
                    <div class="small text-muted">02:30 PM</div>
                </td>
                <td><span class="badge bg-primary-subtle text-primary rounded-1">All Patients</span></td>
                <td>
                    <span class="badge bg-light text-dark rounded-1 border"><i class="fa-solid fa-envelope me-1"></i> Email</span>
                    <span class="badge bg-light text-dark rounded-1 border"><i class="fa-solid fa-comment-sms me-1"></i> SMS</span>
                </td>
                <td><span class="fw-bold">Clinic Holiday Announcement</span></td>
                <td class="text-center">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Sent</span>
                </td>
            </tr>
            <tr>
                <td class="ps-4">
                    <div class="fw-bold mb-0">May 09, 2026</div>
                    <div class="small text-muted">10:15 AM</div>
                </td>
                <td><span class="badge bg-info-subtle text-info rounded-1">Maternity Group</span></td>
                <td>
                    <span class="badge bg-light text-dark rounded-1 border"><i class="fa-solid fa-bell me-1"></i> Push</span>
                </td>
                <td><span class="fw-bold">New Prenatal Care Guide</span></td>
                <td class="text-center">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Sent</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#historyTable').DataTable({
        pageLength: 10,
        ordering: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search history..."
        }
    });
});
</script>
@endpush
@endsection
