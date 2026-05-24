@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <div class="d-flex align-items-center gap-3 mb-2">
                <a href="{{ route('pharmacist.dispense.index') }}" class="btn btn-light rounded-2 btn-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0">Prescription</h4>
                    <p class="text-muted small mb-0">{{ $prescription->diagnosis ?? '—' }}</p>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <span class="status-badge {{ $prescription->status_badge }} px-3 py-2">{{ ucfirst($prescription->status) }}</span>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left: Patient & Prescription Info --}}
        <div class="col-lg-4">
            {{-- Patient Card --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-user me-2"></i>Mgonjwa</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="user-avatar bg-blue-soft text-blue" style="width:64px;height:64px;font-size:1.5rem">
                            {{ strtoupper(substr($prescription->patient->display_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ $prescription->patient->display_name }}</div>
                            <div class="text-muted small">{{ $prescription->patient->patient_number }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Prescription Details --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-pills me-2 text-violet"></i>Maelezo ya Prescription</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted small">Daktari:</span>
                        <div class="fw-semibold small">Dkt. {{ $prescription->doctor->display_name ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted small">Utambuzi:</span>
                        <div class="small">{{ $prescription->diagnosis ?? '—' }}</div>
                    </div>
                    <div>
                        <span class="text-muted small">Maelezo:</span>
                        <div class="small">{{ $prescription->notes ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Items & Dispense --}}
        <div class="col-lg-8">
            {{-- Items List --}}
            <div class="card border-0 shadow-sm mb-4 anim-2">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-blue"></i>Dawa Zilizoandikwa</h6>
                </div>
                <div class="card-body">
                    <form id="dispenseForm">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead><tr>
                                    <th>Dawa</th>
                                    <th>Qty</th>
                                    <th>Dose</th>
                                    <th>Freq</th>
                                    <th>Stock</th>
                                    <th>Toa?</th>
                                </tr></thead>
                                <tbody>
                                    @foreach($prescription->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold small">{{ $item->medicine_name }}</div>
                                            @if($item->medicine)
                                            <div class="text-muted" style="font-size:.7rem">ID: {{ $item->medicine->id }}</div>
                                            @endif
                                        </td>
                                        <td class="small">{{ $item->quantity }}</td>
                                        <td class="small">{{ $item->dosage }}</td>
                                        <td class="small">{{ $item->frequency }}</td>
                                        <td class="small">
                                            @if($item->medicine)
                                            <span class="{{ $item->medicine->quantity >= $item->quantity ? 'text-success' : 'text-danger' }}">
                                                {{ $item->medicine->quantity }}
                                            </span>
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="checkbox" name="items[{{ $item->id }}][dispense]" class="form-check-input dispense-check" checked>
                                            <input type="hidden" name="items[{{ $item->id }}][id]" value="{{ $item->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success fw-semibold w-100 mt-3">
                            <i class="fa-solid fa-check me-2"></i>Toa Dawa Zilizochaguliwa
                        </button>
                    </form>
                </div>
            </div>

            {{-- Cancel Button --}}
            <div class="card border-0 shadow-sm anim-2">
                <div class="card-body">
                    <button class="btn btn-outline-danger w-100" id="cancelBtn">
                        <i class="fa-solid fa-xmark me-2"></i>Futa Prescription (Rudi kwa Daktari)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    const CSRF = '{{ csrf_token() }}';
    const rxId = {{ $prescription->id }};

    // ─── Dispense ─────────────────────────────────────────────
    $('#dispenseForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button[type=submit]').prop('disabled', true);
        $.post(`{{ url('pharmacist/dispense') }}/${rxId}/complete`, $(this).serialize() + '&_token=' + CSRF)
            .done(r => {
                if (r.success) {
                    Swal.fire({
                        icon:'success',
                        title:r.message,
                        text:'Jumla: ' + (r.total_cost || '0'),
                        timer:2000,
                        showConfirmButton:false
                    }).then(() => location.href = '{{ route('pharmacist.dispense.index') }}');
                }
            })
            .fail(xhr => Swal.fire('Hitilafu', xhr.responseJSON?.message ?? 'Imeshindika', 'error'))
            .always(() => $btn.prop('disabled', false));
    });

    // ─── Cancel Prescription ─────────────────────────────────
    $('#cancelBtn').on('click', function () {
        Swal.fire({
            title:'Futa Prescription?', text:'Mgonjwa atarudi kwa daktari.', icon:'warning',
            showCancelButton:true, confirmButtonText:'Ndiyo, Futa', cancelButtonText:'Hapana',
            confirmButtonColor:'#ef4444'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.post(`{{ url('pharmacist/dispense') }}/${rxId}/cancel`, { _token: CSRF })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                            .then(() => location.href = '{{ route('pharmacist.dispense.index') }}');
                    }
                })
                .fail(() => Swal.fire('Hitilafu', 'Imeshindika', 'error'));
        });
    });
});
</script>
@endpush
@endsection
