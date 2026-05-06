@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title ?? 'Dashboard' }}</h1>
                <p class="text-muted">Karibu {{ Auth::user()->name }}. Huu ni ukurasa wako wa usimamizi.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-primary-soft text-primary p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-tasks fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold">Majukumu ya Leo</h5>
                    <p class="text-muted small">Angalia na dhibiti kazi zako za leo.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-success-soft text-success p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-users fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold">Wagonjwa</h5>
                    <p class="text-muted small">Orodha ya wagonjwa waliosajiliwa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-info-soft text-info p-3 rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-chart-pie fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold">Ripoti</h5>
                    <p class="text-muted small">Ripoti na muhtasari wa utendaji.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
</style>
@endsection
