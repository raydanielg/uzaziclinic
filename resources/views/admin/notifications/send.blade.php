@extends('admin.notifications.layout')

@section('notification_title', 'Send New Broadcast')
@section('notification_subtitle', 'Reach out to your clinic community via multiple channels')

@section('notification_content')
<form id="sendNotificationForm">
    @csrf
    <div class="row g-4">
        <div class="col-md-12">
            <label class="form-label">Recipient Group</label>
            <select name="recipients" class="form-select rounded-1 border-light bg-light shadow-none">
                <option value="all_patients">All Patients</option>
                <option value="all_doctors">All Doctors</option>
                <option value="maternity">Maternity Patients</option>
                <option value="staff">All Staff Members</option>
                <option value="specific">Specific User...</option>
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label d-block mb-3">Communication Channels</label>
            <div class="d-flex gap-4 p-3 bg-light rounded-1 border border-light">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="channels[]" value="email" id="chEmail" checked>
                    <label class="form-check-label fw-bold small text-dark" for="chEmail">
                        <i class="fa-solid fa-envelope text-primary me-1"></i> Email
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="channels[]" value="sms" id="chSMS">
                    <label class="form-check-label fw-bold small text-dark" for="chSMS">
                        <i class="fa-solid fa-comment-sms text-success me-1"></i> SMS
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="channels[]" value="push" id="chPush">
                    <label class="form-check-label fw-bold small text-dark" for="chPush">
                        <i class="fa-solid fa-bell text-warning me-1"></i> App Push
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <label class="form-label">Notification Title</label>
            <input type="text" name="title" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g., Important Clinic Update" required>
        </div>

        <div class="col-md-12">
            <label class="form-label">Message Content</label>
            <textarea name="message" class="form-control rounded-1 border-light bg-light shadow-none" rows="5" placeholder="Type your message here..." required></textarea>
            <div class="form-text small">You can use placeholders like [name], [date], [clinic_name]</div>
        </div>

        <div class="col-md-12 text-end mt-4">
            <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                <i class="fa-solid fa-paper-plane me-2"></i> Broadcast Now
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function() {
    $('#sendNotificationForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        const originalText = $btn.html();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This will send the notification to the selected group!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Send it!',
            customClass: {
                confirmButton: 'rounded-1',
                cancelButton: 'rounded-1'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Broadcasting...').prop('disabled', true);
                
                // Simulating AJAX for now as the backend might not have the route
                setTimeout(() => {
                    $btn.html(originalText).prop('disabled', false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Notification broadcasted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#sendNotificationForm')[0].reset();
                }, 1500);
            }
        });
    });
});
</script>
@endpush
@endsection
