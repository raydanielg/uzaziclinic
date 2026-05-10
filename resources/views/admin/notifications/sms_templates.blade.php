@extends('admin.notifications.layout')

@section('notification_title', 'SMS Templates')
@section('notification_subtitle', 'Short and effective SMS messages for quick updates')

@section('notification_content')
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border border-light rounded-1 p-3 bg-light shadow-none">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-1 small">ID: SMS_REMIND</span>
                <span class="small text-muted">160 Characters Max</span>
            </div>
            <h6 class="fw-bold mb-2 text-primary">Appointment Reminder</h6>
            <div class="bg-white p-3 rounded-1 border border-light mb-3">
                <p class="small mb-0 italic text-muted">"Dear [name], just a reminder of your appointment at Uzazi Clinic tomorrow at [time]. See you then!"</p>
            </div>
            <div class="text-end">
                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-pencil me-1"></i> Edit</button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border border-light rounded-1 p-3 bg-light shadow-none">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary rounded-1 small">ID: SMS_PAY</span>
                <span class="small text-muted">160 Characters Max</span>
            </div>
            <h6 class="fw-bold mb-2 text-success">Payment Receipt</h6>
            <div class="bg-white p-3 rounded-1 border border-light mb-3">
                <p class="small mb-0 italic text-muted">"Hi [name], payment of [amount] received for Invoice #[id]. Thank you for choosing Uzazi Clinic."</p>
            </div>
            <div class="text-end">
                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-pencil me-1"></i> Edit</button>
            </div>
        </div>
    </div>
</div>
@endsection
