@extends('layouts.admin')

@section('page_title', 'General Settings')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Clinic Configuration</h5>
            
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Clinic Name</label>
                        <input type="text" class="form-control rounded-3" value="Malkia Uzazi Clinic">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Contact Email</label>
                        <input type="email" class="form-control rounded-3" value="info@malkia.com">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Address</label>
                    <textarea class="form-control rounded-3" rows="2">123 Health St, Dar es Salaam, Tanzania</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Currency</label>
                        <select class="form-select rounded-3">
                            <option selected>Tanzanian Shilling (TSh)</option>
                            <option>US Dollar ($)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Timezone</label>
                        <select class="form-select rounded-3">
                            <option selected>East Africa Time (GMT+3)</option>
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
