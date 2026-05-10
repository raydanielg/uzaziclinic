@foreach($products as $product)
<tr>
    <td class="ps-4">
        <div class="d-flex align-items-center">
            <div class="product-img me-3">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                        <i class="fas fa-image"></i>
                    </div>
                @endif
            </div>
            <div>
                <div class="fw-bold text-dark">{{ $product->name }}</div>
                <small class="text-muted text-truncate d-block" style="max-width: 200px;">{{ $product->description }}</small>
            </div>
        </div>
    </td>
    <td><span class="badge bg-light text-dark border-0 rounded-1 px-2 py-1 fw-normal">{{ $product->category ?? 'General' }}</span></td>
    <td class="fw-bold text-dark small">{{ number_format($product->price, 0) }} TZS</td>
    <td>
        @if($product->stock_quantity <= 5)
            <span class="text-danger fw-bold small"><i class="fas fa-arrow-down me-1"></i>{{ $product->stock_quantity }}</span>
        @else
            <span class="text-dark fw-bold small">{{ $product->stock_quantity }}</span>
        @endif
        <small class="text-muted extra-small">Units</small>
    </td>
    <td>
        @if($product->stock_quantity > 0)
            <span class="badge bg-success-subtle text-success border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">IN STOCK</span>
        @else
            <span class="badge bg-danger-subtle text-danger border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">OUT OF STOCK</span>
        @endif
    </td>
    <td class="text-end pe-4">
        <div class="btn-group shadow-sm rounded-1 overflow-hidden">
            <button class="btn btn-sm btn-white border-0 py-1 px-3 edit-product" 
                    data-id="{{ $product->id }}" 
                    data-name="{{ $product->name }}"
                    data-category="{{ $product->category }}"
                    data-price="{{ $product->price }}"
                    data-quantity="{{ $product->stock_quantity }}"
                    data-description="{{ $product->description }}"
                    title="Edit">
                <i class="fa-solid fa-pen text-primary small"></i>
            </button>
            <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-product" 
                    data-id="{{ $product->id }}" 
                    data-name="{{ $product->name }}"
                    title="Delete">
                <i class="fa-solid fa-trash text-danger small"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
