@extends('layouts.app')

@section('content')
<div class="doctor-chat py-4">
    <div class="container-fluid">
        <div class="row g-0 card border-0 shadow-sm rounded-4 overflow-hidden" style="height: calc(100vh - 150px);">
            <!-- Chat Sidebar (Patient List) -->
            <div class="col-lg-4 border-end bg-white h-100">
                <div class="p-3 border-bottom">
                    <h5 class="fw-bold mb-3">Messages</h5>
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-sm rounded-pill border-light bg-light ps-4" placeholder="Search patients...">
                        <i class="fa-solid fa-magnifying-glass position-absolute start-0 top-50 translate-middle-y ms-3 small text-muted"></i>
                    </div>
                </div>
                <div class="overflow-auto h-100" style="padding-bottom: 100px;">
                    @forelse($patients ?? [] as $patient)
                    <a href="#" class="list-group-item list-group-item-action border-0 p-3 d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <div class="bg-primary-subtle text-primary rounded-circle p-2">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 10px; height: 10px;"></span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 fw-bold text-dark small">{{ $patient->name }}</h6>
                                <small class="text-muted" style="font-size: 0.65rem;">12:30 PM</small>
                            </div>
                            <p class="small text-muted mb-0 text-truncate">Hello doctor, I have a question about my...</p>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5">
                        <p class="text-muted small">No active conversations.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Chat Main Area -->
            <div class="col-lg-8 bg-light h-100 d-flex flex-column">
                <!-- Chat Header -->
                <div class="p-3 bg-white border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-circle p-2">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Select a patient</h6>
                            <small class="text-success fw-bold" style="font-size: 0.7rem;">Active Now</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-light rounded-pill px-3 border-light text-muted"><i class="fa-solid fa-phone"></i></button>
                        <button class="btn btn-sm btn-light rounded-pill px-3 border-light text-muted"><i class="fa-solid fa-video"></i></button>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="flex-grow-1 overflow-auto p-4 d-flex flex-column gap-3">
                    <div class="text-center my-3">
                        <span class="badge bg-white text-muted border rounded-pill px-3 py-2 small fw-normal">Today</span>
                    </div>
                    
                    <!-- Received Message -->
                    <div class="d-flex gap-2 align-items-end" style="max-width: 75%;">
                        <div class="bg-white p-3 rounded-4 shadow-sm border border-light">
                            <p class="small mb-0 text-dark">Hello Doctor, I've been feeling some back pain since yesterday. Is it normal at this stage?</p>
                            <small class="text-muted d-block mt-1" style="font-size: 0.6rem;">12:30 PM</small>
                        </div>
                    </div>

                    <!-- Sent Message -->
                    <div class="d-flex gap-2 align-items-end ms-auto flex-row-reverse" style="max-width: 75%;">
                        <div class="bg-primary text-white p-3 rounded-4 shadow-sm">
                            <p class="small mb-0">Hello! Back pain can be common, but tell me, is it sharp or dull? Also, any other symptoms like fever?</p>
                            <small class="text-white-50 d-block mt-1 text-end" style="font-size: 0.6rem;">12:35 PM</small>
                        </div>
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="p-3 bg-white border-top">
                    <form class="d-flex gap-2 align-items-center">
                        <button type="button" class="btn btn-light rounded-circle border-light text-muted"><i class="fa-solid fa-plus"></i></button>
                        <input type="text" class="form-control rounded-pill border-light bg-light py-2 px-4 shadow-none" placeholder="Type your message here...">
                        <button type="submit" class="btn btn-primary rounded-circle p-2" style="width: 40px; height: 40px;"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item-action.active {
        background-color: #f8fafc !important;
        border-left: 3px solid var(--bs-primary) !important;
    }
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection
