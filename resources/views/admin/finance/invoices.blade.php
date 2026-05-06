@extends('layouts.admin')

@section('page_title', 'All Invoices')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Billing & Invoices</h5>
                <a href="{{ route('admin.finance.receipt') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fa-solid fa-receipt me-2"></i> New Receipt
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Invoice ID</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="fw-bold text-primary">#INV-9901</span></td>
                            <td>Sarah Johnson</td>
                            <td>May 05, 2026</td>
                            <td class="fw-bold">TSh 45,000</td>
                            <td><span class="badge bg-success-subtle text-success">Paid</span></td>
                            <td>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-print"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
