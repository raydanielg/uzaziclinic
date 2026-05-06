@extends('layouts.admin')

@section('page_title', 'Push Notifications')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Send New Notification</h5>
            <form>
                <div class="mb-3">
                    <label class="form-label text-muted">Recipient Group</label>
                    <select class="form-select rounded-3">
                        <option>All Patients</option>
                        <option>All Doctors</option>
                        <option>Active Mothers Group</option>
                        <option>Specific User</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Channel</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" checked id="chEmail">
                            <label class="form-check-label" for="chEmail">Email</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chSMS">
                            <label class="form-check-label" for="chSMS">SMS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chPush">
                            <label class="form-check-label" for="chPush">App Push</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Title</label>
                    <input type="text" class="form-control rounded-3" placeholder="Notification Title">
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Message Content</label>
                    <textarea class="form-control rounded-3" rows="4" placeholder="Write your message here..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-5">Broadcast Notification</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-bold mb-3">Recent Notifications Sent</h6>
            <div class="list-group list-group-flush">
                <div class="list-group-item px-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary-subtle text-primary">Email</span>
                        <span class="text-muted small">1h ago</span>
                    </div>
                    <h6 class="small fw-bold mt-2">Clinic Holiday Announcement</h6>
                    <p class="mb-0 text-muted small">Sent to all patients registered...</p>
                </div>
                <div class="list-group-item px-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success-subtle text-success">SMS</span>
                        <span class="text-muted small">5h ago</span>
                    </div>
                    <h6 class="small fw-bold mt-2">Maternity Checkup Reminder</h6>
                    <p class="mb-0 text-muted small">Sent to Sarah Johnson...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
