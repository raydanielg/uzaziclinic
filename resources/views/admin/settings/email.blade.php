@extends('admin.settings.layout')

@section('settings_title', 'Email Configuration')
@section('settings_group', 'email')

@section('settings_content')
<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">Mail Driver</label>
        <select name="mail_driver" class="form-select rounded-1 border-light bg-light shadow-none">
            <option value="smtp" {{ ($settings['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
            <option value="mailgun" {{ ($settings['mail_driver'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
            <option value="sendmail" {{ ($settings['mail_driver'] ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Mail Host</label>
        <input type="text" name="mail_host" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_host'] ?? 'smtp.mailtrap.io' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mail Port</label>
        <input type="text" name="mail_port" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_port'] ?? '2525' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mail Encryption</label>
        <select name="mail_encryption" class="form-select rounded-1 border-light bg-light shadow-none">
            <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
            <option value="none" {{ ($settings['mail_encryption'] ?? '') == 'none' ? 'selected' : '' }}>None</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Mail Username</label>
        <input type="text" name="mail_username" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_username'] ?? '' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mail Password</label>
        <input type="password" name="mail_password" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_password'] ?? '' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">From Name</label>
        <input type="text" name="mail_from_name" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_from_name'] ?? 'Uzazi Clinic' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">From Email Address</label>
        <input type="email" name="mail_from_address" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['mail_from_address'] ?? 'noreply@uzaziclinic.co.tz' }}">
    </div>
</div>
@endsection
