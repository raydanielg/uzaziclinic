@foreach($labTests ?? [] as $test)
<tr>
    <td class="ps-3">
        <div class="d-flex align-items-center">
            <div class="avatar-sm bg-light text-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fa-solid fa-flask text-primary opacity-75"></i>
            </div>
            <div>
                <span class="fw-bold text-dark d-block text-uppercase small ls-1">#LAB-{{ str_pad($test->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span class="text-muted extra-small">{{ $test->created_at->format('d M, Y') }}</span>
            </div>
        </div>
    </td>
    <td>
        <div class="fw-bold text-dark">{{ $test->patient->display_name ?? 'N/A' }}</div>
        <div class="text-muted extra-small">{{ $test->patient->patient_number ?? '' }}</div>
    </td>
    <td>
        <div class="text-dark fw-medium small">{{ $test->test_name }}</div>
        <span class="badge bg-light text-primary border-0 small fw-normal">{{ $test->test_type }}</span>
    </td>
    <td>
        <div class="text-dark small">Dr. {{ $test->doctor->display_name ?? 'N/A' }}</div>
        <div class="text-muted extra-small">Tech: {{ $test->technician?->name ?? 'Unassigned' }}</div>
    </td>
    <td>
        <span class="badge {{ $test->status_badge }} border-0 px-2 py-1 fw-bold text-uppercase ls-1" style="font-size: 0.6rem;">
            {{ $test->status }}
        </span>
    </td>
    <td class="text-end pe-3">
        <div class="btn-group shadow-sm rounded-1 overflow-hidden">
            <button class="btn btn-sm btn-white border-0 py-1 px-3" title="View">
                <i class="fa-solid fa-eye text-primary small"></i>
            </button>
            <button class="btn btn-sm btn-white border-0 py-1 px-3 delete-test" 
                    data-id="{{ $test->id }}" 
                    title="Delete">
                <i class="fa-solid fa-trash text-danger small"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
