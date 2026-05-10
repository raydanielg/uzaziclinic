@extends('admin.settings.layout')

@section('settings_title', 'SMS Gateway Settings')
@section('settings_group', 'sms')

@section('settings_content')
<div class="row g-4">
    <div class="col-md-12">
        <label class="form-label">SMS Provider</label>
        <select name="sms_provider" class="form-select rounded-1 border-light bg-light shadow-none">
            <option value="twilio" {{ ($settings['sms_provider'] ?? '') == 'twilio' ? 'selected' : '' }}>Twilio</option>
            <option value="beem" {{ ($settings['sms_provider'] ?? '') == 'beem' ? 'selected' : '' }}>Beem (Tanzania)</option>
            <option value="infobip" {{ ($settings['sms_provider'] ?? '') == 'infobip' ? 'selected' : '' }}>Infobip</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">API Key / Account SID</label>
        <input type="text" name="sms_api_key" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['sms_api_key'] ?? '' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">API Secret / Auth Token</label>
        <input type="password" name="sms_api_secret" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['sms_api_secret'] ?? '' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Sender ID / From Number</label>
        <input type="text" name="sms_sender_id" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['sms_sender_id'] ?? 'UZAZICLINIC' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="sms_enabled" value="1" {{ ($settings['sms_enabled'] ?? '') == '1' ? 'checked' : '' }}>
            <label class="form-check-label small text-muted">Enable SMS Notifications</label>
        </div>
    </div>
</div>
@endsection
