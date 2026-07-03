@extends('layouts.app')

@section('content')
<div class="pharmacist-edit-medicine py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-primary">Edit Medicine</h4>
                    <form action="{{ route('pharmacist.medicines.update', $medicine) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Medicine Name</label>
                                <input type="text" name="name" value="{{ old('name', $medicine->name) }}" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="e.g. Paracetamol" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                                <select name="category" class="form-select rounded-1 border-light bg-light shadow-none" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $medicine->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', $medicine->quantity) }}" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Unit Price (TZS)</label>
                                <input type="number" name="price" value="{{ old('price', $medicine->price) }}" class="form-control rounded-1 border-light bg-light shadow-none" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                                <input type="date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date->format('Y-m-d')) }}" class="form-control rounded-1 border-light bg-light shadow-none" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Description</label>
                                <textarea name="description" class="form-control rounded-1 border-light bg-light shadow-none" rows="3">{{ old('description', $medicine->description) }}</textarea>
                            </div>
                            <div class="col-12 text-end pt-3">
                                <a href="{{ route('pharmacist.inventory') }}" class="btn btn-light rounded-1 px-4 me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary rounded-1 px-5 fw-bold border-0">Update Medicine</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
