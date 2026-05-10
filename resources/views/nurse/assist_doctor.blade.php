@extends('layouts.app')

@section('content')
<div class="nurse-assist py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Assist Doctor List</h4>
                <p class="text-muted small">Manage nursing assistance for active clinic doctors.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($doctors as $doc)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-info-soft text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-user-doctor fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1 text-dark">Dr. {{ $doc->name }}</h6>
                    <p class="small text-muted mb-4">Obstetrics & Gynecology</p>
                    
                    <div class="d-flex flex-column gap-2">
                        <div class="bg-light p-2 rounded-1 d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted">Current Status</span>
                            <span class="badge bg-success rounded-pill">In Session</span>
                        </div>
                        <button class="btn btn-primary rounded-1 fw-bold border-0 shadow-none">Assign To Assist</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
