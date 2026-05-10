@extends('layouts.admin')

@section('page_title', 'System Settings')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0">Settings Menu</h6>
            </div>
            <div class="list-group list-group-flush settings-nav">
                <a href="{{ route('admin.settings.general') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.settings.general') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-gears me-2"></i> General Settings
                </a>
                <a href="{{ route('admin.settings.email') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.settings.email') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-envelope me-2"></i> Email Config
                </a>
                <a href="{{ route('admin.settings.sms') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.settings.sms') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-comment-sms me-2"></i> SMS Gateway
                </a>
                <a href="{{ route('admin.settings.gateways') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.settings.gateways') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-credit-card me-2"></i> Payment Gateways
                </a>
                <a href="{{ route('admin.settings.backup') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 {{ Route::is('admin.settings.backup') ? 'active bg-primary-subtle text-primary fw-bold' : 'text-muted' }}">
                    <i class="fa-solid fa-database me-2"></i> System Backup
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">@yield('settings_title', 'General Settings')</h5>
                    <p class="text-muted small mb-0">Configure your system preferences and integrations</p>
                </div>
            </div>

            <form id="settingsForm">
                @csrf
                <input type="hidden" name="group" value="@yield('settings_group', 'general')">
                
                @yield('settings_content')

                <div class="mt-4 pt-3 border-top text-end">
                    <button type="submit" class="btn btn-primary rounded-1 px-5 shadow-sm border-0">
                        <i class="fa-solid fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .settings-nav .list-group-item {
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .settings-nav .list-group-item:hover:not(.active) {
        background-color: #f8fafc;
        color: var(--bs-primary);
    }
    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            const $btn = $(this).find('button[type="submit"]');
            const originalText = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Saving...').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.settings.update') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(resp) {
                    $btn.html(originalText).prop('disabled', false);
                    Swal.fire({ icon: 'success', title: 'Success!', text: resp.message, timer: 1500, showConfirmButton: false });
                },
                error: function() {
                    $btn.html(originalText).prop('disabled', false);
                    Swal.fire('Error!', 'Failed to update settings', 'error');
                }
            });
        });
    });
</script>
@endpush
