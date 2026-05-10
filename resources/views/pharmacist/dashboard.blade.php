@extends('layouts.app')

@section('content')
<div class="pharmacist-dashboard py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Pharmacist Dashboard</h1>
                <p class="text-muted small">Welcome, {{ Auth::user()->name }}. Monitor stock levels and manage prescriptions.</p>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-soft text-primary p-3 rounded-4 me-3">
                            <i class="fa-solid fa-pills fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Total Medicines</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_medicines'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100 border-start border-danger border-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-soft text-danger p-3 rounded-4 me-3">
                            <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Low Stock</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['low_stock'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success p-3 rounded-4 me-3">
                            <i class="fa-solid fa-file-prescription fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Today's Presc.</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['today_prescriptions'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info p-3 rounded-4 me-3">
                            <i class="fa-solid fa-cart-flatbed fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small fw-bold text-uppercase ls-1">Pending Orders</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['pending_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Prescriptions -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-receipt me-2 text-primary"></i>Recent Prescriptions</h5>
                        <a href="{{ route('pharmacist.prescriptions') }}" class="btn btn-sm btn-light rounded-1 text-primary fw-bold px-3 border-0">Process All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Instock</th>
                                        <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Patient</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Doctor</th>
                                        <th class="small text-uppercase fw-bold text-muted border-0">Date</th>
                                        <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_prescriptions as $presc)
                                    <tr>
                                        <td>
                                            <span class="fw-bold {{ ($presc->medicine->quantity ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $presc->medicine->quantity ?? 0 }} {{ $presc->medicine->unit ?? 'pcs' }}
                                            </span>
                                        </td>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $presc->patient->name ?? 'N/A' }}</div>
                                            <div class="small text-muted">ID: #PT-{{ $presc->patient_id }}</div>
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark">Dr. {{ $presc->doctor->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="small text-muted">{{ $presc->created_at->format('M d, Y H:i') }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('pharmacist.prescriptions.dispense', $presc->id) }}" class="btn btn-sm btn-primary rounded-1 px-3 fw-bold border-0 shadow-none">
                                                Dispense
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No recent prescriptions.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold text-danger"><i class="fa-solid fa-bell me-2"></i>Low Stock Alerts</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        @forelse($low_stock_items as $item)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-4 bg-light mb-3 border border-danger border-opacity-10">
                            <div>
                                <h6 class="fw-bold mb-1 small text-dark">{{ $item->name }}</h6>
                                <p class="small text-muted mb-0">Stock: <span class="text-danger fw-bold">{{ $item->quantity }} {{ $item->unit ?? 'pcs' }}</span></p>
                            </div>
                            <a href="{{ route('pharmacist.inventory') }}" class="btn btn-sm btn-white rounded-circle shadow-none border-light">
                                <i class="fa-solid fa-cart-plus text-primary"></i>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fa-solid fa-circle-check fs-1 text-success opacity-25 mb-3"></i>
                            <p class="text-muted small">All medicines are well stocked.</p>
                        </div>
                        @endforelse
                        
                        <a href="{{ route('pharmacist.inventory') }}" class="btn btn-outline-primary rounded-1 w-100 fw-bold py-2 mt-2">
                            Manage Inventory
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .ls-1 { letter-spacing: 1px; }
</style>
@endsection
