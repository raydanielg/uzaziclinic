@extends('layouts.app')

@section('content')
<div class="pharmacist-settings py-4">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Medicine Categories</h5>
                        <button class="btn btn-sm btn-primary rounded-1 px-3 border-0"><i class="fa-solid fa-plus me-1"></i> Add New</button>
                    </div>
                    <ul class="list-group list-group-flush small">
                        @foreach($categories as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-light">
                            <span class="fw-bold text-dark">{{ $cat }}</span>
                            <div>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-edit text-primary"></i></button>
                                <button class="btn btn-sm btn-light rounded-circle"><i class="fa-solid fa-trash text-danger"></i></button>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Unit Management</h5>
                        <button class="btn btn-sm btn-primary rounded-1 px-3 border-0"><i class="fa-solid fa-plus me-1"></i> Add New</button>
                    </div>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0 py-3 border-light">
                            <span class="fw-bold">Tablets (Tab)</span>
                            <span class="badge bg-light text-muted border rounded-pill">System Default</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-3 border-light">
                            <span class="fw-bold">Syrup (Bottle)</span>
                            <span class="badge bg-light text-muted border rounded-pill">System Default</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
