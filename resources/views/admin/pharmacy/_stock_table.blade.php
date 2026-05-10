@foreach($medicines ?? [] as $medicine)
<tr>
    <td class="ps-3">
        <div class="d-flex align-items-center">
            <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fa-solid fa-capsules text-primary opacity-75"></i>
            </div>
            <div>
                <span class="fw-bold text-dark d-block">{{ $medicine->name }}</span>
                <span class="text-muted extra-small text-uppercase ls-1">SKU-{{ str_pad($medicine->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </td>
    <td><span class="badge bg-light text-dark border fw-normal">{{ $medicine->category }}</span></td>
    <td>
        <span class="fw-bold {{ $medicine->quantity <= 10 ? 'text-danger' : 'text-dark' }}">
            {{ $medicine->quantity }}
        </span>
        <small class="text-muted">Units</small>
    </td>
    <td class="text-muted small">{{ $medicine->expiry_date?->format('d M, Y') ?? 'N/A' }}</td>
    <td>
        <span class="badge {{ $medicine->status_badge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
            {{ $medicine->status_label }}
        </span>
    </td>
    <td class="text-end pe-3">
        <div class="btn-group shadow-sm rounded-pill overflow-hidden">
            <button class="btn btn-sm btn-white border-0 py-1 px-3" title="Edit">
                <i class="fa-solid fa-pen text-primary small"></i>
            </button>
            <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-medicine" 
                    data-id="{{ $medicine->id }}" 
                    data-name="{{ $medicine->name }}"
                    title="Delete">
                <i class="fa-solid fa-trash text-danger small"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
@if(count($medicines) == 0)
<tr>
    <td colspan="6" class="text-center py-5 text-muted">
        No medicines found matching your filters.
    </td>
</tr>
@endif
