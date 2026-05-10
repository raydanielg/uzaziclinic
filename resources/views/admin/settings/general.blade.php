@extends('admin.settings.layout')

@section('settings_title', 'General Configuration')
@section('settings_group', 'general')

@section('settings_content')
<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">System Name</label>
        <input type="text" name="system_name" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ $settings['system_name'] ?? 'Uzazi Clinic' }}" required>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary rounded-pill px-5">Save Settings</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h6 class="fw-bold mb-3">System Status</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Database</span>
                <span class="badge bg-success">Connected</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Storage</span>
                <span class="text-dark fw-bold">1.2 GB / 10 GB</span>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-primary" style="width: 12%"></div>
            </div>
        </div>
    </div>
</div>
@endsection
