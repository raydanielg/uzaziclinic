@extends('layouts.app')

@section('content')
<div class="pharmacist-add-medicine py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-primary">Add New Medicine</h4>
                    <form action="{{ route('pharmacist.medicines.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Medicine Name</label>
                                <input type="text" name="name" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. Paracetamol" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                                <select name="category" class="form-select rounded-1 border-light bg-light shadow-none" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Initial Quantity</label>
                                <input type="number" name="quantity" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Unit Price (TZS)</label>
                                <input type="number" name="price" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control rounded-1 border-light bg-light shadow-none" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Description</label>
                                <textarea name="description" class="form-control rounded-1 border-light bg-light shadow-none" rows="3"></textarea>
                            </div>
                            <div class="col-12 text-end pt-3">
                                <button type="reset" class="btn btn-light rounded-1 px-4 me-2">Clear</button>
                                <button type="submit" class="btn btn-primary rounded-1 px-5 fw-bold border-0">Save Medicine</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
