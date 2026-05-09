@extends('layouts.admin')

@section('page_title', 'Add New Product')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Ongeza Bidhaa Mpya</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Jina la Bidhaa</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Mfano: Paracetamol, Baby Care Kit..." required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="">-- Chagua Category --</option>
                                    <option value="Medicines" {{ old('category') == 'Medicines' ? 'selected' : '' }}>Medicines</option>
                                    <option value="Maternity" {{ old('category') == 'Maternity' ? 'selected' : '' }}>Maternity</option>
                                    <option value="Baby Care" {{ old('category') == 'Baby Care' ? 'selected' : '' }}>Baby Care</option>
                                    <option value="Supplements" {{ old('category') == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                                    <option value="Medical Equipment" {{ old('category') == 'Medical Equipment' ? 'selected' : '' }}>Medical Equipment</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Bei (TZS)</label>
                                <div class="input-group">
                                    <span class="input-group-text">TSh</span>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Stock Quantity</label>
                                <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', 0) }}" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Picha ya Bidhaa</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                <small class="text-muted">Max size: 2MB (JPG, PNG)</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="requires_prescription" id="prescriptionCheck" value="1" {{ old('requires_prescription') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="prescriptionCheck">Inahitaji Cheti cha Daktari? (Requires Prescription)</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Maelezo ya Bidhaa (Description)</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Andika maelezo mafupi ya bidhaa hapa...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <hr>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4 py-2 rounded-pill fw-bold me-2">Ghairi</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-save me-2"></i>Hifadhi Bidhaa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-lightbulb me-2 text-warning"></i>Tips</h5>
                    <p class="small text-muted">Hakikisha unapakia picha safi ili kuvutia wateja. Bidhaa zisizo na stock hazitaonekana kwenye duka la upande wa wateja.</p>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-shopping-cart fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-bold">Online Store</h5>
                    <p class="small mb-0">Bidhaa utakazoongeza hapa zitaonekana moja kwa moja kwenye duka la wagonjwa (Patient Shop).</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
