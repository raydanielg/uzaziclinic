@extends('layouts.admin')
@include('partials.dashboard-styles')

@section('page_title', ($type ?? 'All') . ' Appointments')

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0">{{ $type ?? 'All' }} Appointments</h4>
            <p class="text-muted small mb-0">Manage and track patient appointments</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('admin.appointments.today') }}" class="btn btn-sm btn-light rounded-2 fw-semibold">Leo</a>
            <a href="{{ route('admin.appointments.upcoming') }}" class="btn btn-sm btn-light rounded-2 fw-semibold">Inayokuja</a>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light rounded-2 fw-semibold">Zote</a>
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-calendar-plus me-2"></i>Mpya
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @php
            $allAppts = $appointments instanceof \Illuminate\Pagination\LengthAwarePaginator
                ? $appointments->getCollection()
                : collect($appointments ?? []);
        @endphp
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-blue">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-blue"><i class="fa-solid fa-calendar-day"></i></div>
                    <div><div class="stat-label">Leo</div>
                    <div class="stat-value">{{ \App\Models\Appointment::whereDate('appointment_date',today())->count() }}</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-amber">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-amber"><i class="fa-solid fa-clock"></i></div>
                    <div><div class="stat-label">Inasubiri</div>
                    <div class="stat-value">{{ $allAppts->where('status','pending')->count() }}</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-green">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-green"><i class="fa-solid fa-circle-check"></i></div>
                    <div><div class="stat-label">Imethibitishwa</div>
                    <div class="stat-value">{{ $allAppts->where('status','confirmed')->count() }}</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card-modern stat-card-rose">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-rose"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div><div class="stat-label">Imefutwa</div>
                    <div class="stat-value">{{ $allAppts->where('status','cancelled')->count() }}</div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-blue"></i>Miadi Yote</h6>
            <div class="d-flex gap-2">
                <input type="text" id="searchAppt" class="form-control form-control-sm" placeholder="Tafuta mgonjwa au daktari..." style="width:220px">
                <select id="filterStatus" class="form-select form-select-sm" style="width:150px">
                    <option value="">Hali Zote</option>
                    <option value="pending">Inasubiri</option>
                    <option value="confirmed">Imethibitishwa</option>
                    <option value="completed">Imekamilika</option>
                    <option value="cancelled">Imefutwa</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="appointmentsTable">
                <thead><tr>
                    <th class="ps-3">Mgonjwa</th>
                    <th>Daktari</th>
                    <th>Tarehe &amp; Muda</th>
                    <th>Aina</th>
                    <th>Hali</th>
                    <th class="text-end pe-3">Vitendo</th>
                </tr></thead>
                <tbody>
                    @forelse($appointments ?? [] as $appt)
                    @php
                        $pName = $appt->patient->display_name ?? 'N/A';
                        $dName = $appt->doctor->display_name ?? 'N/A';
                        $st = $appt->status ?? 'pending';
                        $sc = match($st) {
                            'confirmed' => ['bg-blue-soft text-blue','fa-circle-check'],
                            'completed' => ['bg-green-soft text-green','fa-check-double'],
                            'cancelled' => ['bg-rose-soft text-rose','fa-circle-xmark'],
                            default     => ['bg-amber-soft text-amber','fa-clock'],
                        };
                    @endphp
                    <tr data-id="{{ $appt->id }}" data-status="{{ $st }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">{{ strtoupper(substr($pName,0,1)) }}</div>
                                <div>
                                    <div class="fw-semibold small">{{ $pName }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $appt->patient->patient_number ?? '' }} | {{ $appt->patient->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold small">Dkt. {{ $dName }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $appt->doctor->specialization ?? 'General' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $appt->appointment_date->format('d M Y') }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $appt->appointment_date->format('h:i A') }}</div>
                        </td>
                        <td class="small text-muted">{{ $appt->type ?? 'General' }}</td>
                        <td>
                            <div class="dropdown d-inline-block">
                                <span class="status-badge {{ $sc[0] }} dropdown-toggle" style="cursor:pointer;"
                                    data-bs-toggle="dropdown">
                                    <i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($st) }}
                                </span>
                                <ul class="dropdown-menu shadow border-0 py-1 small">
                                    <li><a class="dropdown-item py-2 update-status" href="#" data-id="{{ $appt->id }}" data-status="pending">⏳ Inasubiri</a></li>
                                    <li><a class="dropdown-item py-2 update-status" href="#" data-id="{{ $appt->id }}" data-status="confirmed">✅ Thibitisha</a></li>
                                    <li><a class="dropdown-item py-2 update-status" href="#" data-id="{{ $appt->id }}" data-status="completed">🎯 Imekamilika</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li><a class="dropdown-item py-2 update-status text-danger" href="#" data-id="{{ $appt->id }}" data-status="cancelled">❌ Futa</a></li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.appointments.show', $appt->id) }}" class="btn btn-sm btn-light rounded-2 px-2 me-1" title="Maelezo">
                                <i class="fa-solid fa-eye text-blue"></i>
                            </a>
                            <button class="btn btn-sm btn-light rounded-2 px-2 reassign-btn me-1"
                                data-id="{{ $appt->id }}" data-doc="{{ $appt->doctor_id }}" title="Badilisha Daktari">
                                <i class="fa-solid fa-user-doctor text-violet"></i>
                            </button>
                            @if($st !== 'cancelled')
                            <button class="btn btn-sm btn-light rounded-2 px-2 cancel-btn"
                                data-id="{{ $appt->id }}" title="Futa">
                                <i class="fa-solid fa-xmark text-rose"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-calendar-xmark fs-2 opacity-25 d-block mb-2"></i>Hakuna miadi
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($appointments) && $appointments instanceof \Illuminate\Pagination\LengthAwarePaginator && $appointments->hasPages())
        <div class="px-3 py-2 border-top bg-white">{{ $appointments->links() }}</div>
        @endif
    </div>
</div>

{{-- Reassign Doctor Modal --}}
<div class="modal fade" id="reassignModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-doctor me-2"></i>Badilisha Daktari</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <input type="hidden" id="reassignApptId">
                <label class="form-label small fw-bold">Chagua Daktari Mpya</label>
                <select id="reassignDoctorId" class="form-select shadow-none">
                    @foreach(\App\Models\Doctor::with('user')->where('status','active')->get() as $d)
                    <option value="{{ $d->id }}">Dkt. {{ $d->display_name }} — {{ $d->specialization ?? 'General' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer border-0 bg-light py-2">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Funga</button>
                <button type="button" class="btn btn-sm btn-primary" id="doReassign">Hifadhi</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const CSRF = '{{ csrf_token() }}';

    // ── Status dropdown update ────────────────────────────────
    $(document).on('click', '.update-status', function(e) {
        e.preventDefault();
        const id     = $(this).data('id');
        const status = $(this).data('status');
        const $row   = $(`tr[data-id="${id}"]`);

        Swal.fire({
            title: 'Badilisha Hali?',
            text: `Weka hali mpya: ${status}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ndiyo',
            cancelButtonText: 'Hapana'
        }).then(res => {
            if (!res.isConfirmed) return;
            $.ajax({
                url: `{{ url('admin/appointments') }}/${id}/status`,
                method: 'POST',
                data: { _token: CSRF, status: status },
                success: function(resp) {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:'Imebadilishwa!',text:resp.message,timer:1800,showConfirmButton:false})
                            .then(() => location.reload());
                    }
                },
                error: () => Swal.fire('Hitilafu','Imeshindwa kubadilisha','error')
            });
        });
    });

    // ── Cancel button ─────────────────────────────────────────
    $(document).on('click', '.cancel-btn', function() {
        const id   = $(this).data('id');
        const $row = $(`tr[data-id="${id}"]`);
        Swal.fire({
            title: 'Futa Miadi?',
            text: 'Una uhakika unataka kufuta miadi hii?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ndiyo, Futa!',
            cancelButtonText: 'Hapana'
        }).then(res => {
            if (!res.isConfirmed) return;
            $.ajax({
                url: `{{ url('admin/appointments') }}/${id}`,
                method: 'POST',
                data: { _token: CSRF, _method: 'DELETE' },
                success: function(resp) {
                    if (resp.success) {
                        $row.find('.status-badge')
                            .attr('class','status-badge bg-rose-soft text-rose')
                            .html('<i class="fa-solid fa-circle-xmark me-1"></i>Cancelled');
                        $row.find('.cancel-btn').remove();
                        Swal.fire({icon:'success',title:'Imefutwa!',text:resp.message,timer:1800,showConfirmButton:false});
                    }
                },
                error: () => Swal.fire('Hitilafu','Imeshindwa kufuta','error')
            });
        });
    });

    // ── Reassign Doctor ───────────────────────────────────────
    $(document).on('click', '.reassign-btn', function() {
        const id    = $(this).data('id');
        const docId = $(this).data('doc');
        $('#reassignApptId').val(id);
        $('#reassignDoctorId').val(docId);
        const modal = new bootstrap.Modal(document.getElementById('reassignModal'));
        modal.show();
    });

    $('#doReassign').on('click', function() {
        const id  = $('#reassignApptId').val();
        const doc = $('#reassignDoctorId').val();
        $.ajax({
            url: `{{ url('admin/appointments') }}/${id}/reassign`,
            method: 'POST',
            data: { _token: CSRF, doctor_id: doc },
            success: function(resp) {
                if (resp.success) {
                    bootstrap.Modal.getInstance(document.getElementById('reassignModal')).hide();
                    const dName = resp.doctor?.display_name ?? resp.doctor?.name ?? 'Daktari';
                    $(`tr[data-id="${id}"]`).find('td:eq(1)').html(
                        `<div class="fw-semibold small">Dkt. ${dName}</div><div class="text-muted" style="font-size:.75rem">${resp.doctor?.specialization ?? 'General'}</div>`
                    );
                    Swal.fire({icon:'success',title:'Imebadilishwa!',text:resp.message,timer:1800,showConfirmButton:false});
                }
            },
            error: () => Swal.fire('Hitilafu','Imeshindwa kubadilisha daktari','error')
        });
    });

    // ── Search + Filter ───────────────────────────────────────
    function applyFilters() {
        const q  = $('#searchAppt').val().toLowerCase();
        const st = $('#filterStatus').val().toLowerCase();
        $('#appointmentsTable tbody tr').each(function() {
            const text = $(this).text().toLowerCase();
            const rowSt = $(this).data('status') ?? '';
            let show = true;
            if (q && !text.includes(q)) show = false;
            if (st && rowSt !== st) show = false;
            $(this).toggle(show);
        });
    }
    $('#searchAppt, #filterStatus').on('input change', applyFilters);
});
</script>
@endpush
@endsection

