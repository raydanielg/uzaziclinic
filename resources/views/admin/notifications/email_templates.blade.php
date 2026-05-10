@extends('admin.notifications.layout')

@section('notification_title', 'Email Templates')
@section('notification_subtitle', 'Manage and customize your automated email messages')

@section('notification_content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border border-light rounded-1 h-100 p-3 shadow-none bg-light">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-1">
                    <i class="fa-solid fa-user-plus fs-4"></i>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
            <h6 class="fw-bold mb-1">Welcome Email</h6>
            <p class="small text-muted mb-3">Sent to new patients upon registration.</p>
            <div class="mt-auto pt-3 border-top border-white border-opacity-50">
                <button class="btn btn-outline-primary btn-sm rounded-1 w-100">Customize</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border border-light rounded-1 h-100 p-3 shadow-none bg-light">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="bg-success bg-opacity-10 text-success p-2 rounded-1">
                    <i class="fa-solid fa-calendar-check fs-4"></i>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item small" href="#"><i class="fa-solid fa-edit me-2"></i>Edit</a></li>
                        <li><a class="dropdown-item small text-danger" href="#"><i class="fa-solid fa-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
            <h6 class="fw-bold mb-1">Appointment Confirmation</h6>
            <p class="small text-muted mb-3">Sent after a successful booking.</p>
            <div class="mt-auto pt-3 border-top border-white border-opacity-50">
                <button class="btn btn-outline-primary btn-sm rounded-1 w-100">Customize</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border border-dashed rounded-1 h-100 p-4 shadow-none bg-transparent d-flex flex-column align-items-center justify-content-center text-center">
            <div class="bg-light text-muted p-3 rounded-circle mb-3">
                <i class="fa-solid fa-plus fs-3"></i>
            </div>
            <h6 class="fw-bold mb-1">Create New</h6>
            <p class="small text-muted">Add a custom template</p>
            <button class="stretched-link d-none"></button>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>
@endsection
