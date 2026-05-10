@extends('layouts.app')

@section('content')
<div class="pharmacist-suppliers py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-0 text-dark">Suppliers List</h4>
                <p class="text-muted small">Manage medicine suppliers and distributors.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 small text-uppercase fw-bold text-muted border-0">Supplier Name</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Contact Person</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Phone</th>
                            <th class="small text-uppercase fw-bold text-muted border-0">Category</th>
                            <th class="text-end pe-4 small text-uppercase fw-bold text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold">Medix Distributors</td>
                            <td>John Doe</td>
                            <td>+255 712 345 678</td>
                            <td><span class="badge bg-info-subtle text-info rounded-pill px-3">Main</span></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-light rounded-1 border-0"><i class="fa-solid fa-edit text-primary"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
