@extends('admin.settings.layout')

@section('settings_title', 'General Configuration')
@section('settings_group', 'general')

@section('settings_content')
<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">System Name</label>
        <input type="text" name="system_name" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['system_name'] ?? 'Uzazi Clinic' }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Clinic Address</label>
        <input type="text" name="clinic_address" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['clinic_address'] ?? 'Dar es Salaam, TZ' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Contact Phone</label>
        <input type="text" name="contact_phone" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['contact_phone'] ?? '+255...' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Support Email</label>
        <input type="email" name="support_email" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['support_email'] ?? 'support@uzaziclinic.co.tz' }}">
    </div>
    <div class="col-md-12">
        <label class="form-label">Footer Copyright Text</label>
        <input type="text" name="footer_text" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['footer_text'] ?? ' 2026 Uzazi Clinic Management System' }}">
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary rounded-pill px-5">Save Settings</button>
    </div>
</div>
@endsection
