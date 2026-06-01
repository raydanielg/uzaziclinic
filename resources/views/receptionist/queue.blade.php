@extends('layouts.app')
@include('partials.dashboard-styles')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4 anim-1">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-users-line me-2 text-blue"></i>Patient Queue — Today</h4>
            <p class="text-muted small mb-0">{{ now()->format('l, d F Y') }} · Receive patient, register, and send to doctor</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary fw-semibold rounded-2 shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#newVisitModal">
                <i class="fa-solid fa-user-plus me-2"></i>Receive Patient
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4 anim-2">
        @foreach([
            ['fa-users','blue','Total',$stats['total']],
            ['fa-stethoscope','blue','With Doctor',$stats['with_doctor']],
            ['fa-flask','amber','Awaiting Lab',$stats['awaiting_lab']],
            ['fa-pills','violet','Awaiting Pharmacy',$stats['awaiting_pharmacy']],
            ['fa-circle-check','green','Completed',$stats['completed']],
            ['fa-circle-xmark','rose','Cancelled',$stats['cancelled']],
        ] as [$icon,$color,$label,$value])
        <div class="col">
            <div class="stat-card-modern stat-card-{{ $color }}">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon stat-card-{{ $color }}"><i class="fa-solid {{ $icon }}"></i></div>
                    <div>
                        <div class="stat-label">{{ $label }}</div>
                        <div class="stat-value">{{ $value }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Queue Table --}}
    <div class="dash-table-card anim-3">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-blue"></i>Current Queue</h6>
            <div class="d-flex gap-2">
                <input type="text" id="qSearch" class="form-control form-control-sm" placeholder="Search name or number..." style="width:200px">
                <select id="qDoctor" class="form-select form-select-sm" style="width:170px">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $d)
                    <option value="{{ $d->id }}">Dr. {{ $d->display_name }}</option>
                    @endforeach
                </select>
                <select id="qStage" class="form-select form-select-sm" style="width:170px">
                    <option value="">All Stages</option>
                    @foreach(\App\Models\Appointment::STAGES as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="queueTable">
                <thead><tr>
                    <th class="ps-3">Q#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Type</th>
                    <th>Stage</th>
                    <th>Time</th>
                    <th class="text-end pe-3">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse($visits as $v)
                    <tr data-stage="{{ $v->current_stage }}" data-id="{{ $v->id }}" data-doctor="{{ $v->doctor_id ?? '' }}">
                        <td class="ps-3 fw-bold">{{ $v->queue_number ?? '—' }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-blue-soft text-blue">
                                    {{ strtoupper(substr($v->patient->display_name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $v->patient->display_name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $v->patient->patient_number ?? '' }} · {{ $v->patient->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            @if($v->doctor)
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar bg-green-soft text-green" style="width:28px;height:28px;font-size:.7rem">
                                    {{ strtoupper(substr($v->doctor->display_name ?? '?', 0, 1)) }}
                                </div>
                                <span>Dr. {{ $v->doctor->display_name }}</span>
                            </div>
                            @else
                            <span class="text-muted">Not Assigned</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $v->type ?? 'General' }}</td>
                        <td>
                            @php preg_match('/\[Lab: ([^\]]+)\]/', $v->notes ?? '', $lm); @endphp
                            <span class="status-badge {{ $v->stage_badge }}">{{ $v->stage_label }}</span>
                            @if($v->current_stage === 'awaiting_lab' && !empty($lm[1]))
                            <br><small class="fw-semibold text-amber"><i class="fa-solid fa-flask me-1"></i>{{ $lm[1] }}</small>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $v->appointment_date->format('H:i') }}</td>
                        <td class="text-end pe-3">
                            <div class="d-flex gap-1 justify-content-end flex-wrap">
                                @if(!in_array($v->status, ['cancelled','completed']))
                                    @if($v->current_stage === 'with_doctor')
                                    <button class="btn btn-sm btn-light rounded-2" onclick="changeDoctor({{ $v->id }}, {{ $v->doctor_id ?? 'null' }})" title="Badilisha Daktari">
                                        <i class="fa-solid fa-user-doctor text-blue"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning rounded-2" onclick="openSendToLab({{ $v->id }}, '{{ addslashes($v->patient->display_name ?? 'N/A') }}')" title="Peleka Lab">
                                        <i class="fa-solid fa-flask" style="color:#fff"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-success rounded-2" onclick="openPayment({{ $v->id }}, '{{ addslashes($v->patient->display_name ?? 'N/A') }}', '{{ $v->patient->patient_number ?? 'N/A' }}')" title="Lipia &amp; Ruhusu">
                                        <i class="fa-solid fa-money-bill-wave" style="color:#fff"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light rounded-2 cancel-visit" data-id="{{ $v->id }}" title="Futa">
                                        <i class="fa-solid fa-xmark text-rose"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-light rounded-2" onclick="viewMedicalDetails({{ $v->id }}, '{{ addslashes($v->patient->display_name ?? 'N/A') }}', '{{ $v->patient->patient_number ?? 'N/A' }}')" title="Angalia Taarifa">
                                        <i class="fa-solid fa-file-medical text-primary"></i>
                                    </button>
                                    <span class="badge bg-success rounded-2">Imekamilika</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users-slash fs-2 opacity-25 d-block mb-2"></i>No patients in queue today
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Medical Details Modal -->
<div class="modal fade" id="medicalDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-file-medical me-2"></i>Medical Details</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Patient Info -->
                <div class="alert alert-info border-0 d-flex align-items-center gap-3 mb-4">
                    <div class="user-avatar bg-white text-primary" style="width:50px;height:50px;font-size:1.2rem">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold" id="medicalPatientName">Patient Name</div>
                        <div class="small text-muted" id="medicalPatientNumber">PT-001</div>
                    </div>
                </div>

                <!-- Consultation Details -->
                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-stethoscope me-2"></i>Consultation Details</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Doctor:</label>
                            <div class="fw-bold" id="medicalDoctor">-</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted">Date:</label>
                            <div class="fw-bold" id="medicalDate">-</div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="small text-muted">Chief Complaint:</label>
                        <div id="medicalComplaint" class="p-2 bg-white rounded small">-</div>
                    </div>
                    <div>
                        <label class="small text-muted">Diagnosis:</label>
                        <div id="medicalDiagnosis" class="p-2 bg-white rounded small">-</div>
                    </div>
                </div>

                <!-- Prescription -->
                <div class="mb-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-prescription me-2"></i>Prescription</h6>
                    <div id="medicalPrescription" class="p-2 bg-white rounded small">-</div>
                </div>

                <!-- Services -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-list-check me-2"></i>Services Received</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th class="text-end">Cost (TZS)</th>
                            </tr>
                        </thead>
                        <tbody id="medicalServices">
                            <tr>
                                <td>Doctor Consultation</td>
                                <td class="text-end">5,000</td>
                            </tr>
                            <tr>
                                <td>Laboratory Tests</td>
                                <td class="text-end">15,000</td>
                            </tr>
                            <tr>
                                <td>Medication</td>
                                <td class="text-end">25,000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <th class="fw-bold">Total</th>
                                <th class="text-end fw-bold" id="medicalTotal">45,000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Payment Info -->
                <div class="row">
                    <div class="col-md-6">
                        <label class="small text-muted">Payment Method:</label>
                        <div class="fw-bold" id="medicalPaymentMethod">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted">Amount Paid:</label>
                        <div class="fw-bold text-success" id="medicalAmountPaid">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-dark text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-receipt me-2"></i>Payment Receipt</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="receiptContent" class="border p-4 bg-white">
                    <!-- Receipt Header -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h4 class="fw-bold mb-1">Uzazi Clinic</h4>
                        <p class="text-muted small mb-0">Quality Healthcare Services</p>
                        <p class="text-muted small mb-0">Date: <span id="receiptDate"></span></p>
                        <p class="text-muted small mb-0">Receipt #: <span id="receiptNumber"></span></p>
                    </div>

                    <!-- Patient Info -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="small text-muted">Patient Name:</label>
                            <div class="fw-bold" id="receiptPatientName">-</div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted">Patient Number:</label>
                            <div class="fw-bold" id="receiptPatientNumber">-</div>
                        </div>
                    </div>

                    <!-- Case Details -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2"><i class="fa-solid fa-user-injured me-2"></i>Case Details</h6>
                        <div class="small">
                            <label class="text-muted">Chief Complaint:</label>
                            <div id="receiptComplaint">-</div>
                        </div>
                        <div class="small mt-2">
                            <label class="text-muted">Diagnosis:</label>
                            <div id="receiptDiagnosis">-</div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3"><i class="fa-solid fa-list-check me-2"></i>Services Received</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th class="text-end">Cost (TZS)</th>
                                </tr>
                            </thead>
                            <tbody id="receiptServices">
                                <tr class="text-muted"><td colspan="2" class="text-center small py-3">Hakuna huduma zilizochaguliwa</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-dark">
                                    <th class="fw-bold">Total</th>
                                    <th class="text-end fw-bold" id="receiptTotal">45,000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Cash Payment Banner -->
                    <div class="p-3 rounded-3 mb-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-money-bill-wave text-white fs-4"></i>
                            <div>
                                <div class="fw-bold text-white fs-5" id="receiptAmountPaid">-</div>
                                <div class="text-white-50 small">MALIPO YA PESA TASLIMU — Uzazi Clinic</div>
                            </div>
                        </div>
                    </div>

                    <!-- Next appointment box (shown only if set) -->
                    <div id="receiptNextApptBox" style="display:none;" class="p-3 rounded-3 border border-primary-subtle mb-3" style="background:#eff6ff;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-primary fs-5"></i>
                            <div>
                                <div class="small text-primary fw-semibold">Miadi Inayofuata</div>
                                <div class="fw-bold" id="receiptNextAppt">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- SMS sent notice -->
                    <div id="receiptSmsRow" class="alert alert-success border-0 d-flex align-items-center gap-2 py-2 mb-3" style="display:none!important;">
                        <i class="fa-solid fa-message-sms"></i>
                        <small>SMS ya uthibitisho imetumwa kwa mgonjwa.</small>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="small text-muted mb-1">Asante kwa kuchagua Uzazi Clinic</p>
                        <p class="small text-muted mb-0">Tupaze afya njema! · +255 678 233 736</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary rounded-1 px-4" onclick="printReceipt()">
                    <i class="fa-solid fa-print me-2"></i>Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 py-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
                <div>
                    <h6 class="modal-title fw-bold text-white mb-0"><i class="fa-solid fa-money-bill-wave me-2"></i>Lipia &amp; Ruhusu Mgonjwa</h6>
                    <small class="text-white-50">Malipo ya Pesa Taslimu (Cash) Pekee</small>
                </div>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="paymentVisitId">

                <!-- Patient banner -->
                <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="user-avatar bg-success text-white" style="width:48px;height:48px;font-size:1.2rem;">
                        <i class="fa-solid fa-user-nurse"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold fs-6" id="paymentPatientName">-</div>
                        <div class="text-muted small" id="paymentPatientNumber">-</div>
                    </div>
                    <span class="badge px-3 py-2 fw-bold" style="background:#16a34a;font-size:.8rem;">
                        <i class="fa-solid fa-money-bill-wave me-1"></i>CASH
                    </span>
                </div>

                <!-- Huduma za Kliniki -->
                <div class="mb-3">
                    <h6 class="fw-semibold mb-2 small text-uppercase text-muted"><i class="fa-solid fa-list-check me-1"></i>Chagua Huduma Zilizotumiwa</h6>
                    <div class="row g-2 mb-3" id="servicesCheckboxes">
                        @foreach($services as $service)
                        <div class="col-md-6">
                            <label class="d-flex align-items-center gap-2 p-2 rounded-2 border service-check-card" style="cursor:pointer;transition:.15s;">
                                <input class="form-check-input service-checkbox m-0 flex-shrink-0" type="checkbox"
                                       value="{{ $service->id }}"
                                       data-price="{{ $service->price }}"
                                       data-name="{{ $service->name }}">
                                <span class="flex-grow-1 small fw-semibold">{{ $service->name }}</span>
                                <span class="badge bg-success-subtle text-success text-nowrap">TZS {{ number_format($service->price) }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Custom item entry -->
                    <div class="p-3 rounded-3 mb-3" style="background:#f9fafb;border:1px dashed #d1d5db;">
                        <div class="fw-semibold small mb-2 text-muted"><i class="fa-solid fa-plus-circle me-1 text-success"></i>Ongeza Bidhaa / Dawa / Huduma Nyingine</div>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" id="customItemName" class="form-control form-control-sm" placeholder="Jina (mfano: Dawa ya malaria)">
                            </div>
                            <div class="col-4">
                                <input type="number" id="customItemPrice" class="form-control form-control-sm" placeholder="Bei TZS" min="0">
                            </div>
                            <div class="col-2">
                                <button type="button" id="addCustomItemBtn" class="btn btn-success btn-sm w-100" title="Ongeza">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Items table -->
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <thead style="background:#f0fdf4;">
                                <tr>
                                    <th class="small px-2">Huduma / Bidhaa</th>
                                    <th class="text-end small px-2">Kiasi (TZS)</th>
                                    <th style="width:32px;"></th>
                                </tr>
                            </thead>
                            <tbody id="servicesList">
                                <tr class="text-muted"><td colspan="3" class="text-center small py-2">Chagua huduma hapo juu...</td></tr>
                            </tbody>
                            <tfoot>
                                <tr style="background:#15803d;color:#fff;">
                                    <th class="fw-bold px-2">JUMLA YA MALIPO</th>
                                    <th class="text-end fw-bold px-2" id="totalCost">TZS 0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Cash payment section -->
                <div class="p-3 rounded-3 mb-3" style="background:linear-gradient(135deg,#16a34a,#15803d);">
                    <div class="text-white fw-bold mb-2 small"><i class="fa-solid fa-hand-holding-dollar me-2"></i>PESA ZILIZOPOKELEWA (CASH)</div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text fw-bold bg-white">TZS</span>
                                <input type="number" id="amountReceived" class="form-control fw-bold" placeholder="0" min="0" style="font-size:1.1rem;">
                            </div>
                        </div>
                        <div class="col-md-5" id="changeBox" style="display:none;">
                            <div class="text-white-50 small">Chenji ya Kurudisha</div>
                            <div class="fw-bold text-white fs-5">TZS <span id="changeValue">0</span></div>
                        </div>
                    </div>
                </div>

                <!-- Reference (optional) -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Namba ya Risiti (hiari)</label>
                    <input type="text" id="paymentDetails" class="form-control form-control-sm" placeholder="mfano: 2026-0045">
                </div>

                <!-- Next appointment -->
                <div class="p-3 rounded-3" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-calendar-plus text-primary"></i>
                        <span class="fw-semibold small text-primary">Miadi Inayofuata <span class="fw-normal text-muted">(SMS itatumwa mgonjwa)</span></span>
                    </div>
                    <input type="date" id="nextAppointmentDate" class="form-control form-control-sm" min="{{ date('Y-m-d') }}">
                    <p class="text-muted mt-1 mb-0" style="font-size:.73rem;"><i class="fa-solid fa-circle-info me-1"></i>Ukiweka tarehe, SMS itatumwa na tarehe ya miadi na daktari.</p>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-light rounded-2" data-bs-dismiss="modal">Funga</button>
                <button class="btn fw-bold rounded-2 px-4" id="processPaymentBtn" style="background:#16a34a;color:#fff;">
                    <i class="fa-solid fa-check-circle me-2"></i>Thibitisha Malipo ya Cash
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Doctor Modal -->
<div class="modal fade" id="changeDoctorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-doctor me-2"></i>Change Doctor</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="changeVisitId">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select New Doctor</label>
                    <select id="newDoctorSelect" class="form-select" required>
                        <option value="">Loading doctors...</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Reason for Change (Optional)</label>
                    <textarea id="changeReason" rows="3" class="form-control" placeholder="Explain why changing doctor..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-1" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary rounded-1 px-4" id="confirmChangeDoctorBtn"><i class="fa-solid fa-exchange-alt me-2"></i>Change Doctor</button>
            </div>
        </div>
    </div>
</div>

<!-- Send to Lab Modal -->
<div class="modal fade" id="sendToLabModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 py-3" style="background:linear-gradient(135deg,#d97706,#b45309);">
                <div>
                    <h6 class="modal-title fw-bold text-white mb-0"><i class="fa-solid fa-flask me-2"></i>Peleka Mgonjwa Lab</h6>
                    <small class="text-white-50">Chagua sehemu ya lab na utume SMS</small>
                </div>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="labVisitId">

                <div class="d-flex align-items-center gap-2 mb-3 p-2 rounded-3" style="background:#fffbeb;border:1px solid #fde68a;">
                    <i class="fa-solid fa-user-circle text-amber fs-5"></i>
                    <span class="fw-semibold small" id="labPatientName">-</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Sehemu ya Lab <span class="text-danger">*</span></label>
                    <select id="labSectionSelect" class="form-select" required>
                        <option value="">-- Chagua Sehemu --</option>
                        <option value="Haematology (Vipimo vya Damu)">🩸 Haematology — Vipimo vya Damu</option>
                        <option value="Biochemistry (Kemikali za Mwili)">🧪 Biochemistry — Kemikali za Mwili</option>
                        <option value="Microbiology (Viumbe Vidogo)">🦠 Microbiology — Viumbe Vidogo / Utambuzi</option>
                        <option value="Urinalysis (Vipimo vya Mkojo)">💧 Urinalysis — Vipimo vya Mkojo</option>
                        <option value="Ultrasound / Radiolojia">📡 Ultrasound / Radiolojia</option>
                        <option value="Kipimo cha Mimba">🤰 Kipimo cha Mimba</option>
                        <option value="HIV / TB Screening">🔬 HIV / TB Screening</option>
                        <option value="Shinikizo la Damu & Dalili">❤️ Shinikizo la Damu &amp; Dalili za Muhimu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Maelezo ya Ziada <span class="text-muted fw-normal">(hiari)</span></label>
                    <textarea id="labNotes" rows="2" class="form-control form-control-sm" placeholder="Vipimo maalum, maagizo ya daktari..."></textarea>
                </div>

                <div class="form-check form-switch p-3 rounded-3" style="background:#fffbeb;border:1px solid #fde68a;">
                    <input class="form-check-input" type="checkbox" id="sendLabSms" checked>
                    <label class="form-check-label small fw-semibold" for="sendLabSms">
                        <i class="fa-solid fa-message me-1 text-amber"></i>Tuma SMS kwa mgonjwa na maelekezo ya lab
                    </label>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light rounded-2" data-bs-dismiss="modal">Funga</button>
                <button class="btn fw-bold rounded-2 px-4" id="confirmSendToLabBtn" style="background:#d97706;color:#fff;">
                    <i class="fa-solid fa-flask me-2"></i>Peleka Lab
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────────────────────────────────────────────────
     New Visit Modal — Search/Register patient → Send to doctor
     ───────────────────────────────────────────────────────── --}}
<div class="modal fade" id="newVisitModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h6 class="modal-title fw-bold"><i class="fa-solid fa-user-plus me-2"></i>Receive New Patient</h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                {{-- Step 1: Find or register --}}
                <div id="stepFind">
                    <ul class="nav nav-pills nav-fill mb-3 small" id="patientTabs">
                        <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="pill" data-bs-target="#tabExisting"><i class="fa-solid fa-magnifying-glass me-1"></i>Existing Patient</button></li>
                        <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="pill" data-bs-target="#tabNew"><i class="fa-solid fa-user-plus me-1"></i>New Patient</button></li>
                    </ul>

                    <div class="tab-content">
                        {{-- Existing --}}
                        <div class="tab-pane fade show active" id="tabExisting">
                            <label class="form-label small fw-bold">Search by Name, Phone or Number (PT-001)</label>
                            <input type="text" id="patientSearch" class="form-control shadow-none" placeholder="Type name or phone...">
                            <div id="searchResults" class="mt-2" style="max-height:280px;overflow-y:auto"></div>
                        </div>

                        {{-- New --}}
                        <div class="tab-pane fade" id="tabNew">
                            <form id="registerForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Full Name *</label>
                                        <input type="text" name="name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Phone *</label>
                                        <input type="text" name="phone" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control shadow-none">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Gender *</label>
                                        <select name="gender" class="form-select shadow-none" required>
                                            <option value="">--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Blood Type</label>
                                        <select name="blood_group" class="form-select shadow-none">
                                            <option value="">--</option>
                                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                            <option>{{ $bg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold">Emergency Contact</label>
                                        <input type="text" name="emergency_contact" class="form-control shadow-none">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Allergies</label>
                                        <textarea name="allergies" rows="2" class="form-control shadow-none"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success fw-semibold mt-3 w-100">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Register & Continue
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Send to doctor --}}
                <div id="stepSend" style="display:none">
                    <div class="alert alert-success border-0 d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <div class="fw-bold small">Patient Selected:</div>
                            <div id="selectedPatientName" class="small"></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-light ms-auto" id="changePatientBtn">Change</button>
                    </div>

                    <input type="hidden" id="selPatientId">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Doctor *</label>
                            <select id="sendDoctor" class="form-select shadow-none" required>
                                <option value="">-- Select Doctor --</option>
                                @foreach($doctors as $d)
                                <option value="{{ $d->id }}">Dr. {{ $d->display_name }} — {{ $d->specialization ?? 'General' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Service Type</label>
                            <select id="sendType" class="form-select shadow-none">
                                <option>General Consultation</option>
                                <option>Follow-up</option>
                                <option>Maternal Care</option>
                                <option>Vaccination</option>
                                <option>Emergency</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Reason for Visit (Chief Complaint)</label>
                            <textarea id="sendComplaint" rows="3" class="form-control shadow-none" placeholder="Example: Stomach pain for 3 days..."></textarea>
                        </div>
                    </div>
                    <button type="button" id="sendToDoctorBtn" class="btn btn-primary fw-semibold mt-3 w-100">
                        <i class="fa-solid fa-paper-plane me-2"></i>Send to Doctor
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
    let searchTimer = null;
    let customItems = [];

    // ─── Step 1a: Search existing patient ───────────────────
    $('#patientSearch').on('input', function () {
        const q = $(this).val().trim();
        clearTimeout(searchTimer);
        if (q.length < 2) { $('#searchResults').empty(); return; }

        searchTimer = setTimeout(() => {
            $.get('{{ route("receptionist.visits.search") }}', { q })
                .done(resp => {
                    const list = resp.data || [];
                    if (!list.length) {
                        $('#searchResults').html('<div class="text-center py-3 text-muted small"><i class="fa-solid fa-circle-question me-1"></i>No results. Register as new.</div>');
                        return;
                    }
                    let html = '';
                    list.forEach(p => {
                        html += `
                        <div class="d-flex align-items-center gap-2 p-2 rounded-2 border mb-1 patient-row" style="cursor:pointer"
                            data-id="${p.id}" data-name="${p.name}" data-num="${p.patient_number}">
                            <div class="user-avatar bg-blue-soft text-blue">${(p.name||'?')[0].toUpperCase()}</div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">${p.name}</div>
                                <div class="text-muted" style="font-size:.7rem">${p.patient_number} · ${p.phone||''}</div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </div>`;
                    });
                    $('#searchResults').html(html);
                });
        }, 300);
    });

    $(document).on('click', '.patient-row', function () {
        $('#selPatientId').val($(this).data('id'));
        $('#selectedPatientName').text(`${$(this).data('num')} — ${$(this).data('name')}`);
        $('#stepFind').hide();
        $('#stepSend').show();
    });

    $('#changePatientBtn').on('click', () => {
        $('#stepSend').hide();
        $('#stepFind').show();
        $('#selPatientId').val('');
    });

    // ─── Step 1b: Register new patient ──────────────────────
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();
        const $btn = $(this).find('button[type=submit]').prop('disabled', true);
        $.ajax({
            url: '{{ route("receptionist.visits.register") }}',
            method: 'POST',
            data: $(this).serialize() + '&_token=' + CSRF,
        }).done(r => {
            if (r.success) {
                $('#selPatientId').val(r.patient.id);
                $('#selectedPatientName').text(`${r.patient.patient_number} — ${r.patient.name}`);
                $('#stepFind').hide();
                $('#stepSend').show();
                Swal.fire({icon:'success',title:r.message,timer:1400,showConfirmButton:false});
                $('#registerForm')[0].reset();
            } else {
                Swal.fire('Error', r.message || 'Failed', 'error');
            }
        }).fail(xhr => {
            const msg = xhr.responseJSON?.message ?? Object.values(xhr.responseJSON?.errors ?? {}).flat().join('\n') ?? 'Imeshindwa';
            Swal.fire('Error', msg, 'error');
        }).always(() => $btn.prop('disabled', false));
    });

    // ─── Step 2: Send to doctor ─────────────────────────────
    $('#sendToDoctorBtn').on('click', function () {
        const patient_id = $('#selPatientId').val();
        const doctor_id  = $('#sendDoctor').val();
        if (!patient_id || !doctor_id) {
            return Swal.fire('Warning', 'Please select patient and doctor', 'warning');
        }
        const $btn = $(this).prop('disabled', true);
        $.post('{{ route("receptionist.visits.send") }}', {
            _token: CSRF,
            patient_id, doctor_id,
            type: $('#sendType').val(),
            chief_complaint: $('#sendComplaint').val(),
        }).done(r => {
            if (r.success) {
                Swal.fire({icon:'success',title:r.message,timer:1600,showConfirmButton:false})
                    .then(() => location.reload());
            } else {
                Swal.fire('Hitilafu', r.message, 'error');
            }
        }).fail(xhr => {
            Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
        }).always(() => $btn.prop('disabled', false));
    });

    // ─── Cancel visit ──────────────────────────────────────
    $(document).on('click', '.cancel-visit', function () {
        const id = $(this).data('id');
        Swal.fire({
            title:'Cancel appointment?', icon:'warning', showCancelButton:true,
            confirmButtonText:'Yes, Cancel', cancelButtonText:'No',
            confirmButtonColor:'#ef4444'
        }).then(r => {
            if (!r.isConfirmed) return;
            $.post(`{{ url('receptionist/visits') }}/${id}/cancel`, { _token: CSRF })
                .done(resp => {
                    if (resp.success) {
                        Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                            .then(() => location.reload());
                    }
                });
        });
    });

    // ─── Filter ────────────────────────────────────────────
    function applyFilter() {
        const q = $('#qSearch').val().toLowerCase();
        const s = $('#qStage').val();
        const d = $('#qDoctor').val();
        $('#queueTable tbody tr').each(function () {
            const txt = $(this).text().toLowerCase();
            const stg = $(this).data('stage') ?? '';
            const doc = $(this).data('doctor') ?? '';
            let show = true;
            if (q && !txt.includes(q)) show = false;
            if (s && stg !== s) show = false;
            if (d && doc !== d) show = false;
            $(this).toggle(show);
        });
    }
    $('#qSearch, #qStage, #qDoctor').on('input change', applyFilter);

    // ─── Change Doctor ─────────────────────────────────────
    window.changeDoctor = function(visitId, currentDoctorId) {
        $('#changeVisitId').val(visitId);
        const modal = new bootstrap.Modal(document.getElementById('changeDoctorModal'));
        const doctorSelect = $('#newDoctorSelect');
        
        doctorSelect.html('<option value="">Loading doctors...</option>');
        modal.show();
        
        // Load doctors
        $.get('{{ route("receptionist.doctors") }}')
            .done(function(data) {
                if (data.success && data.doctors) {
                    doctorSelect.html('<option value="">Select a doctor</option>' +
                        data.doctors.map(function(d) {
                            const selected = d.id === currentDoctorId ? 'selected' : '';
                            return `<option value="${d.id}" ${selected}>Dr. ${d.name}</option>`;
                        }).join(''));
                } else {
                    doctorSelect.html('<option value="">No doctors available</option>');
                }
            })
            .fail(function() {
                doctorSelect.html('<option value="">Failed to load doctors</option>');
            });
    };

    $('#confirmChangeDoctorBtn').on('click', function() {
        const visitId = $('#changeVisitId').val();
        const newDoctorId = $('#newDoctorSelect').val();
        const reason = $('#changeReason').val();
        
        if (!newDoctorId) {
            return Swal.fire('Warning', 'Please select a doctor', 'warning');
        }
        
        const $btn = $(this).prop('disabled', true);
        $.post('{{ route("receptionist.visits.change-doctor") }}', {
            _token: CSRF,
            visit_id: visitId,
            doctor_id: newDoctorId,
            reason: reason
        }).done(function(r) {
            if (r.success) {
                Swal.fire({icon:'success',title:r.message,timer:1500,showConfirmButton:false})
                    .then(() => location.reload());
            } else {
                Swal.fire('Error', r.message, 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
        }).always(function() {
            $btn.prop('disabled', false);
        });
    });

    // ─── Mark Completed ─────────────────────────────────────
    window.markCompleted = function(visitId) {
        Swal.fire({
            title:'Mark as completed?',
            text:'This will mark the patient visit as completed',
            icon:'question',
            showCancelButton:true,
            confirmButtonText:'Yes, Complete',
            cancelButtonText:'No',
            confirmButtonColor:'#22c55e'
        }).then(function(r) {
            if (!r.isConfirmed) return;
            
            $.post('{{ route("receptionist.visits.complete") }}', {
                _token: CSRF,
                visit_id: visitId
            }).done(function(resp) {
                if (resp.success) {
                    Swal.fire({icon:'success',title:resp.message,timer:1400,showConfirmButton:false})
                        .then(() => location.reload());
                }
            }).fail(function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed', 'error');
            });
        });
    };

    // ─── Payment & Discharge ───────────────────────────────
    window.openPayment = function(visitId, patientName, patientNumber) {
        $('#paymentVisitId').val(visitId);
        $('#paymentPatientName').text(patientName);
        $('#paymentPatientNumber').text(patientNumber);
        
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
        
        // Reset form
        $('#amountReceived').val('');
        $('#paymentDetails').val('');
        $('#nextAppointmentDate').val('');
        $('#changeBox').hide();
        customItems = [];
        $('.service-checkbox').prop('checked', false);
        updateServicesTable();
    };

    // Number format helper
    function number_format(num, decimals) {
        return num.toLocaleString('en-US', { minimumFractionDigits: decimals ?? 0, maximumFractionDigits: decimals ?? 0 });
    }

    // Update the full items table (DB services + custom items)
    function updateServicesTable() {
        const rows = [];
        let total = 0;

        // DB-backed checkboxes
        $('.service-checkbox:checked').each(function() {
            const name  = $(this).data('name');
            const price = parseFloat($(this).data('price')) || 0;
            rows.push({ name, price, custom: false });
            total += price;
        });

        // Custom items
        customItems.forEach((item, idx) => {
            rows.push({ name: item.name, price: item.price, custom: true, idx });
            total += item.price;
        });

        if (rows.length === 0) {
            $('#servicesList').html('<tr class="text-muted"><td colspan="3" class="text-center small py-2">Chagua huduma hapo juu...</td></tr>');
        } else {
            $('#servicesList').html(rows.map(r => `
                <tr>
                    <td class="px-2 small">${r.name}</td>
                    <td class="text-end px-2 small">${number_format(r.price)}</td>
                    <td class="px-1">${r.custom ? `<button type="button" class="btn btn-sm btn-light p-0 px-1 remove-custom" data-idx="${r.idx}" title="Ondoa"><i class="fa-solid fa-xmark text-rose" style="font-size:.7rem"></i></button>` : ''}</td>
                </tr>`).join(''));
        }
        $('#totalCost').text('TZS ' + number_format(total));
        recalcChange();
    }

    // Remove custom item
    $(document).on('click', '.remove-custom', function() {
        customItems.splice($(this).data('idx'), 1);
        updateServicesTable();
    });

    // Add custom item button
    $('#addCustomItemBtn').on('click', function() {
        const name  = $('#customItemName').val().trim();
        const price = parseFloat($('#customItemPrice').val()) || 0;
        if (!name) return Swal.fire('Taja Jina', 'Andika jina la huduma/bidhaa kwanza.', 'warning');
        if (price <= 0) return Swal.fire('Bei Sahihi', 'Weka bei zaidi ya 0.', 'warning');
        customItems.push({ name, price });
        $('#customItemName').val('');
        $('#customItemPrice').val('');
        updateServicesTable();
    });

    // Service checkbox change handler
    $(document).on('change', '.service-checkbox', function() {
        updateServicesTable();
    });

    // Recalculate change
    function recalcChange() {
        const totalText = $('#totalCost').text().replace('TZS ', '').replace(/,/g, '');
        const total     = parseFloat(totalText) || 0;
        const received  = parseFloat($('#amountReceived').val()) || 0;
        const change    = received - total;
        if (received > 0 && change >= 0) {
            $('#changeValue').text(number_format(change));
            $('#changeBox').show();
        } else {
            $('#changeBox').hide();
        }
    }

    // Calculate change on input
    $('#amountReceived').on('input', recalcChange);

    $('#processPaymentBtn').on('click', function() {
        const visitId        = $('#paymentVisitId').val();
        const amountReceived = $('#amountReceived').val();
        const nextAppt       = $('#nextAppointmentDate').val();
        const ref            = $('#paymentDetails').val();

        if (!amountReceived || parseFloat(amountReceived) <= 0) {
            return Swal.fire('Taja Kiasi', 'Weka jumla ya pesa zilizopokelewa.', 'warning');
        }

        const totalText = $('#totalCost').text().replace('TZS ', '').replace(/,/g, '');
        const total     = parseFloat(totalText) || 0;
        if (total > 0 && parseFloat(amountReceived) < total) {
            return Swal.fire('Haitoshi', `Kiasi kilichowekwa (TZS ${number_format(parseFloat(amountReceived))}) ni kidogo kuliko jumla (TZS ${number_format(total)}).`, 'warning');
        }

        const $btn = $(this).prop('disabled', true);
        $btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Inashughulikiwa...');

        $.post('{{ route("receptionist.visits.payment") }}', {
            _token:           CSRF,
            visit_id:         visitId,
            payment_method:   'cash',
            payment_details:  ref,
            amount_received:  amountReceived,
            next_appointment: nextAppt || null
        }).done(function(r) {
            if (r.success) {
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();

                // Populate receipt
                const d = new Date();
                $('#receiptDate').text(d.toLocaleDateString('sw-TZ', { day:'2-digit', month:'short', year:'numeric' }));
                $('#receiptNumber').text('RCP-' + Date.now().toString().slice(-8));
                $('#receiptPatientName').text($('#paymentPatientName').text());
                $('#receiptPatientNumber').text($('#paymentPatientNumber').text());
                $('#receiptComplaint').text(r.data?.complaint || '—');
                $('#receiptDiagnosis').text(r.data?.diagnosis || '—');

                // Copy itemized services (remove action column for receipt)
                const rows = [];
                $('.service-checkbox:checked').each(function() {
                    rows.push(`<tr><td>${$(this).data('name')}</td><td class="text-end">${number_format(parseFloat($(this).data('price')))}</td></tr>`);
                });
                customItems.forEach(ci => {
                    rows.push(`<tr><td>${ci.name}</td><td class="text-end">${number_format(ci.price)}</td></tr>`);
                });
                $('#receiptServices').html(rows.length ? rows.join('') : '<tr><td colspan="2" class="text-muted text-center small">—</td></tr>');
                $('#receiptTotal').text($('#totalCost').text());

                // Cash amount paid
                $('#receiptAmountPaid').text('TZS ' + number_format(parseFloat(amountReceived)));

                // Next appointment
                if (nextAppt) {
                    const nd = new Date(nextAppt);
                    $('#receiptNextAppt').text(nd.toLocaleDateString('sw-TZ', { weekday:'long', day:'numeric', month:'long', year:'numeric' }));
                    $('#receiptNextApptBox').show();
                } else {
                    $('#receiptNextApptBox').hide();
                }

                // Reset and show receipt
                $('#nextAppointmentDate').val('');
                customItems = [];
                updateServicesTable();
                const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                receiptModal.show();
            } else {
                Swal.fire('Hitilafu', r.message, 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Hitilafu', xhr.responseJSON?.message ?? 'Imeshindwa', 'error');
        }).always(function() {
            $btn.prop('disabled', false);
            $btn.html('<i class="fa-solid fa-check-circle me-2"></i>Thibitisha Malipo ya Cash');
        });
    });

    // ─── Send to Lab ────────────────────────────────────────
    window.openSendToLab = function(visitId, patientName) {
        $('#labVisitId').val(visitId);
        $('#labPatientName').text(patientName);
        $('#labSectionSelect').val('');
        $('#labNotes').val('');
        $('#sendLabSms').prop('checked', true);
        new bootstrap.Modal(document.getElementById('sendToLabModal')).show();
    };

    $('#confirmSendToLabBtn').on('click', function() {
        const visitId    = $('#labVisitId').val();
        const labSection = $('#labSectionSelect').val();
        if (!labSection) return Swal.fire('Chagua Sehemu', 'Tafadhali chagua sehemu ya lab.', 'warning');

        const $btn = $(this).prop('disabled', true);
        $btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Inapeleka...');

        $.post('{{ route("receptionist.visits.send-to-lab") }}', {
            _token:      CSRF,
            visit_id:    visitId,
            lab_section: labSection,
            lab_notes:   $('#labNotes').val(),
            send_sms:    $('#sendLabSms').is(':checked') ? 1 : 0
        }).done(function(r) {
            if (r.success) {
                bootstrap.Modal.getInstance(document.getElementById('sendToLabModal')).hide();
                Swal.fire({ icon: 'success', title: r.message, text: 'SMS imetumwa mgonjwa.', timer: 2000, showConfirmButton: false })
                    .then(() => location.reload());
            } else {
                Swal.fire('Hitilafu', r.message, 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Hitilafu', xhr.responseJSON?.message ?? 'Imeshindwa', 'error');
        }).always(function() {
            $btn.prop('disabled', false);
            $btn.html('<i class="fa-solid fa-flask me-2"></i>Peleka Lab');
        });
    });

    // Print receipt
    window.printReceipt = function() {
        const receiptContent = document.getElementById('receiptContent').innerHTML;
        const printWindow = window.open('', '', 'width=600,height=800');
        printWindow.document.write(`
            <html>
            <head>
                <title>Payment Receipt</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 20px; }
                    @media print { body { padding: 0; } }
                </style>
            </head>
            <body>
                ${receiptContent}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    };

    // ─── View Medical Details ───────────────────────────────
    window.viewMedicalDetails = function(visitId, patientName, patientNumber) {
        $('#medicalPatientName').text(patientName);
        $('#medicalPatientNumber').text(patientNumber);
        
        const modal = new bootstrap.Modal(document.getElementById('medicalDetailsModal'));
        modal.show();
        
        // Load medical details
        $.get('{{ route("receptionist.visits.medical-details") }}', { visit_id: visitId })
            .done(function(data) {
                if (data.success) {
                    $('#medicalDoctor').text(data.data?.doctor || 'N/A');
                    $('#medicalDate').text(data.data?.date || 'N/A');
                    $('#medicalComplaint').text(data.data?.complaint || 'N/A');
                    $('#medicalDiagnosis').text(data.data?.diagnosis || 'N/A');
                    $('#medicalPrescription').text(data.data?.prescription || 'N/A');
                    $('#medicalPaymentMethod').text(data.data?.payment_method || 'N/A');
                    $('#medicalAmountPaid').text('TZS ' + (data.data?.amount_paid || '0').toLocaleString());
                }
            })
            .fail(function() {
                Swal.fire('Error', 'Failed to load medical details', 'error');
            });
    };
});
</script>
@endpush
@endsection
