@extends('admin.settings.layout')

@section('settings_title', 'Payment Gateways')
@section('settings_group', 'gateways')

@section('settings_content')
<div class="row g-4">
    <div class="col-12">
        <h6 class="fw-bold mb-3 small text-primary"><i class="fa-solid fa-mobile-screen-button me-2"></i>Mobile Money (Beem/Selcom)</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Gateway API ID</label>
                <input type="text" name="payment_api_id" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['payment_api_id'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Gateway API Key</label>
                <input type="password" name="payment_api_key" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['payment_api_key'] ?? '' }}">
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="col-12">
        <h6 class="fw-bold mb-3 small text-primary"><i class="fa-solid fa-credit-card me-2"></i>Card Payments (Stripe/Flutterwave)</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Public Key</label>
                <input type="text" name="payment_public_key" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['payment_public_key'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Secret Key</label>
                <input type="password" name="payment_secret_key" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['payment_secret_key'] ?? '' }}">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Currency</label>
        <input type="text" name="currency" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['currency'] ?? 'TZS' }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Test Mode</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="payment_test_mode" value="1" {{ ($settings['payment_test_mode'] ?? '') == '1' ? 'checked' : '' }}>
            <label class="form-check-label small text-muted">Enable Sandbox/Testing</label>
        </div>
    </div>
</div>
@endsection
