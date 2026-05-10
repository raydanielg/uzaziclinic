@extends('admin.settings.layout')

@section('settings_title', 'System Backup')
@section('settings_group', 'backup')

@section('settings_content')
<div class="row g-4">
    <div class="col-md-12">
        <div class="p-4 bg-light rounded-1 border border-dashed text-center mb-4">
            <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted opacity-25 mb-3"></i>
            <h6 class="fw-bold">Automatic Backups</h6>
            <p class="small text-muted">Secure your data by scheduling daily automated backups to cloud storage.</p>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Backup Frequency</label>
        <select name="backup_frequency" class="form-select rounded-1 border-light bg-light shadow-none">
            <option value="daily" {{ ($settings['backup_frequency'] ?? '') == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ ($settings['backup_frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ ($settings['backup_frequency'] ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Retention Period (Days)</label>
        <input type="number" name="backup_retention" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['backup_retention'] ?? '30' }}">
    </div>
    <div class="col-md-12">
        <label class="form-label">Cloud Storage Destination</label>
        <select name="backup_storage" class="form-select rounded-1 border-light bg-light shadow-none">
            <option value="local" {{ ($settings['backup_storage'] ?? '') == 'local' ? 'selected' : '' }}>Local Storage</option>
            <option value="s3" {{ ($settings['backup_storage'] ?? '') == 's3' ? 'selected' : '' }}>Amazon S3</option>
            <option value="gdrive" {{ ($settings['backup_storage'] ?? '') == 'gdrive' ? 'selected' : '' }}>Google Drive</option>
            <option value="dropbox" {{ ($settings['backup_storage'] ?? '') == 'dropbox' ? 'selected' : '' }}>Dropbox</option>
        </select>
    </div>
    <div class="col-md-12">
        <div class="card border-light bg-light rounded-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 small">Last Backup</h6>
                    <p class="small text-muted mb-0">{{ $settings['last_backup_date'] ?? 'Never performed' }}</p>
                </div>
                <button type="button" class="btn btn-secondary btn-sm rounded-1 px-3">
                    <i class="fa-solid fa-play me-2"></i> Run Backup Now
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>
@endsection
