@extends('layouts.admin')
@include('partials.dashboard-styles')

@section('page_title', 'Maelezo ya Miadi #' . $appointment->id)

@section('content')
<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0">Miadi #{{ $appointment->id }}</h4>
            <p class="text-muted small mb-0">Maelezo kamili ya miadi</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-light rounded-2 fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i>Rudi
            </a>
        </div>
    </div>

    @php
        $st = $appointment->status ?? 'pending';
        $sc = match($st) {
            'confirmed' => ['bg-blue-soft text-blue','fa-circle-check'],
            'completed' => ['bg-green-soft text-green','fa-check-double'],
            'cancelled' => ['bg-rose-soft text-rose','fa-circle-xmark'],
            default     => ['bg-amber-soft text-amber','fa-clock'],
        };
        $pName = $appointment->patient->display_name ?? 'N/A';
        $dName = $appointment->doctor->display_name ?? 'N/A';
    @endphp

    <div class="row g-4">
        {{-- Left: Appointment Info --}}
        <div class="col-lg-8 anim-2">
            <div class="dash-chart-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-blue"></i>Taarifa ya Miadi</h6>
                    <span class="status-badge {{ $sc[0] }}"><i class="fa-solid {{ $sc[1] }} me-1"></i>{{ ucfirst($st) }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Mgonjwa</div>
                            <div class="fw-bold">{{ $pName }}</div>
                            <div class="text-muted small">{{ $appointment->patient->patient_number ?? '' }} | {{ $appointment->patient->phone ?? '' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Daktari</div>
                            <div class="fw-bold">Dkt. {{ $dName }}</div>
                            <div class="text-muted small">{{ $appointment->doctor->specialization ?? 'General' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Tarehe &amp; Muda</div>
                            <div class="fw-bold">{{ $appointment->appointment_date->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $appointment->appointment_date->format('h:i A') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Aina</div>
                            <div class="fw-bold">{{ $appointment->type ?? 'General Consultation' }}</div>
                        </div>
                        @if($appointment->symptoms)
                        <div class="col-12">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Dalili / Sababu</div>
                            <div class="p-3 rounded-3 bg-light small">{{ $appointment->symptoms }}</div>
                        </div>
                        @endif
                        @if($appointment->notes)
                        <div class="col-12">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Maelezo</div>
                            <div class="p-3 rounded-3 bg-light small">{{ $appointment->notes }}</div>
                        </div>
                        @endif
                        @if($appointment->diagnosis)
                        <div class="col-12">
                            <div class="small text-muted fw-semibold text-uppercase mb-1">Utambuzi</div>
                            <div class="p-3 rounded-3" style="background:#f0fdf4">{{ $appointment->diagnosis }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Status History Timeline --}}
            <div class="dash-chart-card">
                <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2 text-violet"></i>Mstari wa Wakati</h6></div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="activity-dot" style="background:#10b981;width:10px;height:10px;flex-shrink:0;margin-top:4px;border-radius:50%;"></div>
                        <div>
                            <div class="fw-semibold small">Miadi Ilisajiliwa</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $appointment->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @if($appointment->status !== 'pending')
                    <div class="activity-item">
                        <div class="activity-dot" style="background:#2563eb;width:10px;height:10px;flex-shrink:0;margin-top:4px;border-radius:50%;"></div>
                        <div>
                            <div class="fw-semibold small">Hali Imebadilishwa: {{ ucfirst($appointment->status) }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $appointment->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="col-lg-4 anim-3">
            {{-- Update Status --}}
            <div class="dash-chart-card mb-4">
                <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-sliders me-2 text-blue"></i>Badilisha Hali</h6></div>
                <div class="card-body d-flex flex-column gap-2 pt-3">
                    @foreach(['pending'=>['⏳','bg-amber-soft text-amber'],'confirmed'=>['✅','bg-blue-soft text-blue'],'completed'=>['🎯','bg-green-soft text-green'],'cancelled'=>['❌','bg-rose-soft text-rose']] as $s=>[$icon,$cls])
                    <button class="quick-action-item update-status-btn @if($st===$s) fw-bold @endif"
                        data-status="{{ $s }}" style="{{ $st===$s ? 'background:#f1f5f9;' : '' }}">
                        <div class="qa-icon {{ $cls }}">{{ $icon }}</div>
                        <span>{{ ucfirst($s) }}</span>
                        @if($st===$s)<i class="fa-solid fa-check ms-auto text-green"></i>@endif
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Reassign Doctor --}}
            <div class="dash-chart-card">
                <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fa-solid fa-user-doctor me-2 text-violet"></i>Badilisha Daktari</h6></div>
                <div class="card-body pt-3">
                    <select id="newDoctorId" class="form-select shadow-none mb-3">
                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}" @if($d->id===$appointment->doctor_id) selected @endif>
                            Dkt. {{ $d->display_name }} — {{ $d->specialization ?? 'General' }}
                        </option>
                        @endforeach
                    </select>
                    <button id="doReassignBtn" class="btn btn-primary fw-semibold w-100 rounded-2">
                        <i class="fa-solid fa-save me-2"></i>Hifadhi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const CSRF = '{{ csrf_token() }}';
    const APPT_ID = {{ $appointment->id }};

    $('.update-status-btn').on('click', function() {
        const status = $(this).data('status');
        Swal.fire({
            title: 'Badilisha Hali?',
            text: `Weka hali mpya: ${status}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ndiyo',
            cancelButtonText: 'Hapana'
        }).then(res => {
            if (!res.isConfirmed) return;
            $.post(`{{ url('admin/appointments') }}/${APPT_ID}/status`, { _token: CSRF, status })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:'Imebadilishwa!',text:resp.message,timer:1800,showConfirmButton:false})
                            .then(() => location.reload());
                    }
                })
                .fail(() => Swal.fire('Hitilafu','Imeshindwa kubadilisha','error'));
        });
    });

    $('#doReassignBtn').on('click', function() {
        const docId = $('#newDoctorId').val();
        $.post(`{{ url('admin/appointments') }}/${APPT_ID}/reassign`, { _token: CSRF, doctor_id: docId })
            .done(resp => {
                if (resp.success) {
                    Swal.fire({icon:'success',title:'Imebadilishwa!',text:resp.message,timer:1800,showConfirmButton:false})
                        .then(() => location.reload());
                }
            })
            .fail(() => Swal.fire('Hitilafu','Imeshindwa kubadilisha daktari','error'));
    });
});
</script>
@endpush
@endsection
