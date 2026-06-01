@extends('admin.settings.layout')

@section('settings_title', 'SMS Gateway Configuration')
@section('settings_group', 'sms')

@section('settings_content')
<div class="row g-4">
    <!-- Provider Selection Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                    <i class="fa-solid fa-comment-sms fa-xl"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1 text-dark">SMS Provider Configuration</h6>
                    <p class="text-muted small mb-0">Select and configure your SMS gateway provider</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold text-dark small text-uppercase">SMS Provider</label>
                    <select name="sms_provider" class="form-select rounded-3 border-2 p-3 shadow-none" style="border-color: #e5e7eb;">
                        <option value="">-- Select Provider --</option>
                        <option value="twilio" {{ ($settings['sms_provider'] ?? '') == 'twilio' ? 'selected' : '' }}>Twilio (Global)</option>
                        <option value="beem" {{ ($settings['sms_provider'] ?? '') == 'beem' ? 'selected' : '' }}>Beem (Tanzania)</option>
                        <option value="infobip" {{ ($settings['sms_provider'] ?? '') == 'infobip' ? 'selected' : '' }}>Infobip (Global)</option>
                        <option value="africastalking" {{ ($settings['sms_provider'] ?? '') == 'africastalking' ? 'selected' : '' }}>Africa's Talking</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">API Key / Account SID</label>
                    <input type="text" name="sms_api_key" class="form-control rounded-3 border-2 p-3 shadow-none" style="border-color: #e5e7eb;" value="{{ $settings['sms_api_key'] ?? '' }}" placeholder="Enter API key">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">API Secret / Auth Token</label>
                    <input type="password" name="sms_api_secret" class="form-control rounded-3 border-2 p-3 shadow-none" style="border-color: #e5e7eb;" value="{{ $settings['sms_api_secret'] ?? '' }}" placeholder="Enter API secret">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">Sender ID / From Number</label>
                    <input type="text" name="sms_sender_id" class="form-control rounded-3 border-2 p-3 shadow-none" style="border-color: #e5e7eb;" value="{{ $settings['sms_sender_id'] ?? 'UZAZICLINIC' }}" placeholder="e.g., UZAZICLINIC">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="sms_enabled" value="1" {{ ($settings['sms_enabled'] ?? '') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark">Enable SMS Notifications</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4">
                    <i class="fa-solid fa-save me-2"></i> Save Configuration
                </button>
                <button type="button" class="btn btn-outline-secondary rounded-3 fw-bold px-4" onclick="testSMS()">
                    <i class="fa-solid fa-paper-plane me-2"></i> Test SMS
                </button>
                <button type="button" class="btn btn-outline-danger rounded-3 fw-bold px-4 ms-auto" onclick="resetSMSConfig()">
                    <i class="fa-solid fa-trash me-2"></i> Reset Configuration
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary bg-opacity-5">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-3 me-3">
                    <i class="fa-solid fa-envelope-open-text fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">SMS Templates</h6>
                    <p class="text-muted small mb-0">Manage your automated SMS templates</p>
                </div>
                <a href="{{ route('admin.notifications.smsTemplates') }}" class="btn btn-primary rounded-3 fw-bold px-3">
                    Manage
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-success bg-opacity-5">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-3 me-3">
                    <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark">SMS History</h6>
                    <p class="text-muted small mb-0">View sent SMS logs and status</p>
                </div>
                <a href="{{ route('admin.notifications.history') }}" class="btn btn-success rounded-3 fw-bold px-3">
                    View
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function testSMS() {
    Swal.fire({
        title: 'Send Test SMS',
        input: 'text',
        inputLabel: 'Phone Number',
        inputPlaceholder: '+255...',
        showCancelButton: true,
        confirmButtonText: 'Send Test',
        confirmButtonColor: '#3b82f6',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value) {
                return 'Please enter a phone number'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Test SMS Sent!',
                text: 'A test SMS has been sent to ' + result.value,
                confirmButtonColor: '#3b82f6'
            })
        }
    })
}

function resetSMSConfig() {
    Swal.fire({
        title: 'Reset SMS Configuration?',
        text: 'This will clear all your SMS gateway settings. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Reset It',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Clear all SMS settings
            document.querySelector('[name="sms_provider"]').value = '';
            document.querySelector('[name="sms_api_key"]').value = '';
            document.querySelector('[name="sms_api_secret"]').value = '';
            document.querySelector('[name="sms_sender_id"]').value = 'UZAZICLINIC';
            document.querySelector('[name="sms_enabled"]').checked = false;
            
            Swal.fire({
                icon: 'success',
                title: 'Reset Complete',
                text: 'SMS configuration has been reset to defaults',
                confirmButtonColor: '#3b82f6'
            })
        }
    })
}
</script>
@endsection
