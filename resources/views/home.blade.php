@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold text-success mb-1">Karibu, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-muted mb-0">Umeingia kama <strong>{{ ucfirst(Auth::user()->role->name ?? 'Mtumiaji') }}</strong>. Huu ni ukurasa wako mkuu wa huduma.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <span class="badge bg-success-soft text-success p-2 px-3 rounded-pill border border-success">
                                <i class="fa-solid fa-circle-check me-1"></i> System Online
                            </span>
                            <span class="badge bg-primary-soft text-primary p-2 px-3 rounded-pill border border-primary">
                                <i class="fa-solid fa-clock me-1"></i> {{ date('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Common Statistics or Quick Links -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="card-body">
                    <div class="stat-icon bg-primary-soft text-primary mb-3">
                        <i class="fa-solid fa-user-gear fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Wasifu (Profile)</h5>
                    <p class="text-muted small">Hariri taarifa zako za wasifu na mipangilio ya akaunti.</p>
                    <a href="#" class="btn btn-primary btn-sm rounded-pill px-4">Angalia Profile</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="card-body">
                    <div class="stat-icon bg-success-soft text-success mb-3">
                        <i class="fa-solid fa-bell fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Taarifa (Notifications)</h5>
                    <p class="text-muted small">Angalia taarifa na ujumbe mpya kutoka kwenye mfumo.</p>
                    <a href="#" class="btn btn-success btn-sm rounded-pill px-4">Fungua</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="card-body">
                    <div class="stat-icon bg-warning-soft text-warning mb-3">
                        <i class="fa-solid fa-headset fa-xl"></i>
                    </div>
                    <h5 class="fw-bold">Msaada (Support)</h5>
                    <p class="text-muted small">Unahitaji msaada? Wasiliana na timu ya ufundi hapa.</p>
                    <a href="#" class="btn btn-warning btn-sm rounded-pill px-4">Tuma Ombi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(22, 101, 52, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
