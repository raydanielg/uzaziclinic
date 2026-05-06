@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 animate__animated animate__fadeIn">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white overflow-hidden position-relative">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-md-8">
                        <h2 class="fw-bold text-success mb-1">Karibu, {{ Auth::user()->name }}! 👋</h2>
                        <p class="text-muted mb-0">Huu ni ukurasa wako wa huduma za afya na ununuzi. Unafanya nini leo?</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <a href="{{ route('appointments') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                                <i class="fas fa-plus me-2"></i>Book New
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Abstract Background Shape -->
                <div class="position-absolute" style="right: -30px; top: -30px; width: 150px; height: 150px; background: rgba(22, 163, 74, 0.05); border-radius: 50%;"></div>
            </div>
        </div>
    </div>

    <!-- Quick Stats for Patient -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white text-center">
                <div class="stat-icon bg-success-soft text-success mx-auto mb-2">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
                <div class="fw-bold h5 mb-0">0</div>
                <div class="text-muted small">Miadi (Active)</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white text-center">
                <div class="stat-icon bg-primary-soft text-primary mx-auto mb-2">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                </div>
                <div class="fw-bold h5 mb-0">0</div>
                <div class="text-muted small">Cart Items</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white text-center">
                <div class="stat-icon bg-info-soft text-info mx-auto mb-2">
                    <i class="fas fa-file-prescription fa-lg"></i>
                </div>
                <div class="fw-bold h5 mb-0">0</div>
                <div class="text-muted small">Prescriptions</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white text-center">
                <div class="stat-icon bg-warning-soft text-warning mx-auto mb-2">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
                <div class="fw-bold h5 mb-0">0</div>
                <div class="text-muted small">Pending Invoices</div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Sections -->
    <div class="row g-4">
        <!-- Clinic Services -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Clinic Services</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush gap-3">
                        <a href="{{ route('appointments') }}" class="list-group-item list-group-item-action border-0 rounded-4 p-3 bg-light-hover">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-white shadow-sm"><i class="fas fa-calendar-alt text-success"></i></div>
                                <div>
                                    <div class="fw-bold">Weka Miadi (Appointments)</div>
                                    <div class="text-muted small">Chagua daktari na mda wa kuja kliniki</div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0 rounded-4 p-3 bg-light-hover">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-white shadow-sm"><i class="fas fa-flask text-info"></i></div>
                                <div>
                                    <div class="fw-bold">Majibu ya Maabara (Lab Results)</div>
                                    <div class="text-muted small">Angalia majibu yako ya vipimo</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shop & Store -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Shop & Wellness</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush gap-3">
                        <a href="{{ route('shop.index') }}" class="list-group-item list-group-item-action border-0 rounded-4 p-3 bg-light-hover">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-white shadow-sm"><i class="fas fa-store text-primary"></i></div>
                                <div>
                                    <div class="fw-bold">Kununua Bidhaa (Shop)</div>
                                    <div class="text-muted small">Dawa, vifaa vya afya, na virutubisho</div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('shop.cart') }}" class="list-group-item list-group-item-action border-0 rounded-4 p-3 bg-light-hover">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-white shadow-sm"><i class="fas fa-shopping-cart text-warning"></i></div>
                                <div>
                                    <div class="fw-bold">Rukwama Yangu (My Cart)</div>
                                    <div class="text-muted small">Kagua bidhaa ulizochagua tayari</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(22, 163, 74, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    
    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .bg-light-hover:hover {
        background-color: #f8f9fa !important;
        transform: translateX(5px);
        transition: all 0.3s ease;
    }

    .list-group-item {
        transition: all 0.3s ease;
    }
</style>
@endsection
