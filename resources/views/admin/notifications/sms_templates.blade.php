@extends('admin.notifications.layout')

@section('notification_title', 'SMS Templates Management')
@section('notification_subtitle', 'Manage and customize your automated SMS messages')

@section('notification_content')
<div class="row g-4">
    @foreach($realTemplates as $key => $template)
    @php
        $textLen = strlen($template['value']);
        $segments = $textLen > 160 ? ceil($textLen / 153) : 1;
        $segmentLabel = $segments . ($segments === 1 ? ' Segment' : ' Segments');
        $charPercent = min(100, ($textLen / 160) * 100);
        $barColor = $charPercent > 90 ? 'danger' : ($charPercent > 75 ? 'warning' : 'success');

        // Icon based on template type
        $icon = 'fa-comment-sms';
        $iconBg = 'linear-gradient(135deg, #6366f1, #4f46e5)';
        if (str_contains($key, 'welcome')) {
            $icon = 'fa-hand-sparkles';
            $iconBg = 'linear-gradient(135deg, #10b981, #059669)';
        } elseif (str_contains($key, 'confirmation')) {
            $icon = 'fa-calendar-check';
            $iconBg = 'linear-gradient(135deg, #3b82f6, #2563eb)';
        } elseif (str_contains($key, 'reminder')) {
            $icon = 'fa-bell';
            $iconBg = 'linear-gradient(135deg, #f59e0b, #d97706)';
        } elseif (str_contains($key, 'payment')) {
            $icon = 'fa-credit-card';
            $iconBg = 'linear-gradient(135deg, #8b5cf6, #7c3aed)';
        } elseif (str_contains($key, 'lab')) {
            $icon = 'fa-flask';
            $iconBg = 'linear-gradient(135deg, #ec4899, #db2777)';
        } elseif (str_contains($key, 'service')) {
            $icon = 'fa-stethoscope';
            $iconBg = 'linear-gradient(135deg, #06b6d4, #0891b2)';
        }
    @endphp
    <div class="col-md-6 col-lg-4 mb-2">
        <div class="card h-100 border-0 shadow-hover rounded-4 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle" style="background: {{ $iconBg }};">
                            <i class="fa-solid {{ $icon }}"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark" style="font-size:0.9rem;">{{ $template['title'] }}</h6>
                            <span class="badge bg-soft-{{ $barColor }} fw-normal px-2 py-1 rounded-pill" style="font-size:0.65rem;">
                                <i class="fa-regular fa-clock me-1"></i>{{ $segmentLabel }}
                            </span>
                        </div>
                    </div>
                    <div class="form-check form-switch" style="min-width: 70px;">
                        <input class="form-check-input" type="checkbox"
                               id="toggle_{{ $key }}"
                               onchange="toggleTemplate('{{ $key }}', this.checked)"
                               {{ ($template['enabled'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-medium d-block text-center" for="toggle_{{ $key }}" style="font-size:0.6rem;">
                            {{ ($template['enabled'] ?? true) ? 'Enabled' : 'Disabled' }}
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-muted mb-3" style="font-size:0.78rem; line-height:1.4;">{{ $template['description'] }}</p>

                <!-- Preview Tabs -->
                <div class="preview-tabs mb-3">
                    <ul class="nav nav-pills nav-fill gap-1 mb-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-1 px-2" data-bs-toggle="tab"
                                    data-bs-target="#raw-{{ Str::slug($key) }}" type="button" role="tab"
                                    style="font-size:0.7rem;">
                                <i class="fa-regular fa-code me-1"></i> Template
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-1 px-2" data-bs-toggle="tab"
                                    data-bs-target="#sample-{{ Str::slug($key) }}" type="button" role="tab"
                                    style="font-size:0.7rem;">
                                <i class="fa-regular fa-eye me-1"></i> Sample
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="raw-{{ Str::slug($key) }}" role="tabpanel">
                            <div class="preview-box">
                                <small class="text-muted" style="white-space: pre-line; font-size:0.75rem; line-height:1.4;">{{ Str::limit($template['value'], 200) }}</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sample-{{ Str::slug($key) }}" role="tabpanel">
                            <div class="preview-box preview-sample">
                                <small style="white-space: pre-line; font-size:0.75rem; line-height:1.4;">{{ Str::limit($template['sample'], 200) }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between small text-muted mb-1" style="font-size:0.7rem;">
                        <span><i class="fa-regular fa-file-lines me-1"></i> <strong class="text-dark">{{ $textLen }}</strong> chars</span>
                        <span><i class="fa-regular fa-rectangle-ad me-1"></i> <strong class="text-{{ $barColor }}">{{ $segmentLabel }}</strong></span>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-{{ $barColor }}" role="progressbar"
                             style="width: {{ $charPercent }}%;" aria-valuenow="{{ $charPercent }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                <!-- Placeholders -->
                <div class="mb-3">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size:0.6rem; letter-spacing:0.5px;">
                        <i class="fa-solid fa-tags me-1"></i> Placeholders
                    </small>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($template['placeholders'] as $ph)
                        <span class="ph-badge">{{ $ph }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Spacer + Actions -->
                <div class="mt-auto">
                    <button class="btn btn-primary w-100 btn-open-editor rounded-3 fw-bold py-2.5"
                            data-key="{{ $key }}"
                            data-title="{{ $template['title'] }}"
                            data-description="{{ $template['description'] }}"
                            data-value="{{ $template['value'] }}"
                            data-placeholders='@json($template['placeholders'])'
                            style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);">
                        <i class="fa-solid fa-pen-to-square me-2"></i> Edit Template
                    </button>
                    <button class="btn btn-outline-danger w-100 mt-2 reset-template rounded-3 py-2"
                            data-key="{{ $key }}"
                            data-title="{{ $template['title'] }}"
                            title="Reset to default"
                            style="font-size: 0.85rem;">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset to Default
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Edit SMS Template - Slide-in Sidebar Panel -->
<div id="editSmsSidebar" class="sms-editor-sidebar">
    <div class="sms-editor-overlay" id="smsEditorOverlay"></div>
    <div class="sms-editor-panel" id="smsEditorPanel">
        <div class="sms-editor-header">
            <div class="d-flex align-items-center gap-3">
                <div class="editor-icon">
                    <i class="fa-regular fa-message"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-white" id="editSmsModalLabel">Edit SMS Template</h5>
                    <p class="small mb-0 text-white-50" id="smsModalDescription" style="font-size:0.75rem;"></p>
                </div>
            </div>
            <button type="button" class="editor-close" id="smsEditorClose" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editSmsForm" class="sms-editor-body">
            @csrf
            <input type="hidden" name="key" id="smsTemplateKey">

            <div class="px-4 py-3">
                <div class="mb-3">
                    <label class="form-label fw-bold mb-2 text-dark d-flex align-items-center gap-2">
                        <i class="fa-regular fa-pen-to-square text-primary"></i> SMS Content <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control font-monospace border-2 rounded-3 p-3 shadow-none"
                              name="value"
                              id="smsTemplateValue"
                              rows="6"
                              style="resize: vertical; font-size: 0.9rem; border-color: #e5e7eb;"
                              required></textarea>
                </div>

                <!-- Stats Card -->
                <div class="stats-card mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-uppercase small" style="font-size:0.65rem; letter-spacing:0.5px; color:#64748b;">
                            <i class="fa-regular fa-chart-bar me-1"></i> Message Stats
                        </span>
                        <span id="charPercent" class="fw-bold text-success small">0 / 160 chars</span>
                    </div>
                    <div class="progress mb-2" style="height: 6px;">
                        <div id="charProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted small" style="font-size:0.75rem;">
                        <div>Characters: <span id="charCount" class="fw-bold text-dark">0</span></div>
                        <div>Segments: <span id="segmentCount" class="fw-bold text-success">1 Segment</span></div>
                    </div>
                </div>

                <!-- Quick Insert Placeholders -->
                <div class="mb-3 p-3 rounded-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-uppercase small" style="font-size:0.65rem; letter-spacing:0.5px; color:#64748b;">
                            <i class="fa-solid fa-wand-magic-sparkles text-primary me-1"></i> Quick Insert
                        </span>
                        <small class="text-muted" style="font-size:0.65rem;">Click to insert at cursor</small>
                    </div>
                    <div class="d-flex flex-wrap gap-1" id="placeholdersContainer"></div>
                </div>

                <!-- Live Sample Preview -->
                <div class="live-preview p-3 rounded-3" style="background:#fefce8; border:1px solid #fde68a;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-uppercase small" style="font-size:0.65rem; letter-spacing:0.5px; color:#92400e;">
                            <i class="fa-regular fa-eye me-1"></i> Live Preview
                        </span>
                        <button type="button" id="copyPreviewBtn" class="btn btn-sm py-0 px-2" style="font-size:0.65rem; background:#fef3c7; color:#92400e; border:1px solid #fcd34d;">
                            <i class="fa-regular fa-copy me-1"></i> Copy
                        </button>
                    </div>
                    <div id="livePreview" class="small" style="font-size:0.78rem; line-height:1.5; color:#78350f; white-space:pre-line;">
                        Start typing to see a preview with sample data...
                    </div>
                </div>
            </div>

            <div class="sms-editor-footer">
                <button type="button" class="btn btn-light rounded-3 fw-bold px-4 py-2" id="smsEditorCancel" style="font-size:0.85rem;">
                    <i class="fa-regular fa-xmark me-1"></i> Cancel
                </button>
                <button type="submit" id="saveTemplateBtn" class="btn btn-success rounded-3 fw-bold px-4 py-2" style="font-size:0.85rem;">
                    <span class="btn-text"><i class="fa-regular fa-floppy-disk me-1"></i> Save Changes</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const sampleData = {
    patient_name: 'John',
    patient_ID: 'UZC-001234',
    doctor_name: 'Mlay',
    appointment_date: '15/06/2026',
    appointment_time: '10:30 AM',
    service_name: 'General Checkup',
    amount: '25,000',
    payment_date: '01/06/2026',
    receipt_number: 'RCP-006789',
    next_appointment_date: '15/06/2026',
    account_name: 'Uzazi Clinic Account',
    tigo_yas: '0623123456',
    tigo_pesa: '0623123456',
    mpesa: '0712123456',
    crdb_bank: '0151234567890',
    queue_number: 'Q-042',
    lab_section: 'Hematology',
    test_name: 'Blood Count',
    test_date: '01/06/2026',
};

function renderPreview(text) {
    let rendered = text;
    Object.keys(sampleData).forEach(ph => {
        const regex = new RegExp('\\[' + ph + '\\]', 'g');
        rendered = rendered.replace(regex, '<span class="sample-val">' + sampleData[ph] + '</span>');
    });
    return rendered || '<span style="color:#94a3b8;font-style:italic;">Start typing to see a preview with sample data...</span>';
}

function toggleTemplate(key, enabled) {
    Swal.fire({
        title: enabled ? 'Enable Template?' : 'Disable Template?',
        text: 'Are you sure you want to ' + (enabled ? 'enable' : 'disable') + ' this SMS template?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: enabled ? '#16a34a' : '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, ' + (enabled ? 'enable' : 'disable') + ' it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/admin/notifications/sms-templates/toggle', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ key: key, enabled: enabled })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Updated!', text: data.message, confirmButtonColor: '#16a34a', timer: 2000, showConfirmButton: false });
                    const label = document.querySelector('label[for="toggle_' + key + '"]');
                    if (label) label.textContent = enabled ? 'Enabled' : 'Disabled';
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: data.message || 'Something went wrong.', confirmButtonColor: '#dc2626' });
                    const toggle = document.getElementById('toggle_' + key);
                    if (toggle) toggle.checked = !enabled;
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to toggle template.', confirmButtonColor: '#dc2626' });
                const toggle = document.getElementById('toggle_' + key);
                if (toggle) toggle.checked = !enabled;
            });
        } else {
            const toggle = document.getElementById('toggle_' + key);
            if (toggle) toggle.checked = !enabled;
        }
    });
}

document.querySelectorAll('.reset-template').forEach(btn => {
    btn.addEventListener('click', function() {
        const key = this.getAttribute('data-key');
        const title = this.getAttribute('data-title');

        Swal.fire({
            title: 'Reset "' + title + '"?',
            html: 'This will restore the <strong>default message</strong>.<br>Your custom changes will be lost.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, reset it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/admin/notifications/sms-templates/reset', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ key: key })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Reset Complete!', text: data.message, confirmButtonColor: '#16a34a' }).then(() => { window.location.reload(); });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Reset Failed', text: data.message || 'Something went wrong.', confirmButtonColor: '#dc2626' });
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while resetting.', confirmButtonColor: '#dc2626' });
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('editSmsSidebar');
    const panel = document.getElementById('smsEditorPanel');
    const overlay = document.getElementById('smsEditorOverlay');
    const closeBtn = document.getElementById('smsEditorClose');
    const cancelBtn = document.getElementById('smsEditorCancel');
    const openBtns = document.querySelectorAll('.btn-open-editor');
    const placeholdersContainer = document.getElementById('placeholdersContainer');
    const templateValueInput = document.getElementById('smsTemplateValue');
    const charCountEl = document.getElementById('charCount');
    const segmentCountEl = document.getElementById('segmentCount');
    const charProgressEl = document.getElementById('charProgress');
    const charPercentEl = document.getElementById('charPercent');
    const livePreviewEl = document.getElementById('livePreview');
    const copyBtn = document.getElementById('copyPreviewBtn');

    // ---- Sidebar Open/Close ----
    function openEditor() {
        sidebar.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeEditor() {
        sidebar.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', closeEditor);
    if (cancelBtn) cancelBtn.addEventListener('click', closeEditor);
    if (overlay) overlay.addEventListener('click', closeEditor);

    // Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) closeEditor();
    });

    // ---- Open buttons ----
    openBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const key = this.getAttribute('data-key');
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');
            const value = this.getAttribute('data-value');
            const placeholders = JSON.parse(this.getAttribute('data-placeholders'));

            document.getElementById('editSmsModalLabel').textContent = 'Edit: ' + title;
            document.getElementById('smsModalDescription').textContent = description;
            document.getElementById('smsTemplateKey').value = key;
            templateValueInput.value = value;

            placeholdersContainer.innerHTML = '';
            placeholders.forEach(ph => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'ph-insert-btn';
                btn.textContent = '[' + ph + ']';
                btn.title = 'Insert [' + ph + ']';

                btn.addEventListener('click', function() {
                    const startPos = templateValueInput.selectionStart;
                    const endPos = templateValueInput.selectionEnd;
                    const phText = '[' + ph + ']';
                    templateValueInput.value = templateValueInput.value.substring(0, startPos) + phText + templateValueInput.value.substring(endPos);
                    templateValueInput.focus();
                    templateValueInput.selectionStart = templateValueInput.selectionEnd = startPos + phText.length;
                    updateCounts();
                });

                placeholdersContainer.appendChild(btn);
            });

            updateCounts();
            openEditor();
        });
    });

    // ---- Live character count ----
    function updateCounts() {
        const text = templateValueInput.value;
        const len = text.length;
        charCountEl.textContent = len;

        let segments = 1;
        if (len > 160) segments = Math.ceil(len / 153);
        const segmentText = segments + (segments === 1 ? ' Segment' : ' Segments');
        segmentCountEl.textContent = segmentText;

        const pct = Math.min(100, (len / 160) * 100);
        if (charProgressEl) {
            charProgressEl.style.width = pct + '%';
            charProgressEl.className = 'progress-bar';
            if (pct > 90) charProgressEl.classList.add('bg-danger');
            else if (pct > 75) charProgressEl.classList.add('bg-warning');
            else charProgressEl.classList.add('bg-success');
        }
        if (charPercentEl) {
            charPercentEl.textContent = len + ' / 160 chars';
            charPercentEl.className = 'fw-bold small';
            if (pct > 90) charPercentEl.classList.add('text-danger');
            else if (pct > 75) charPercentEl.classList.add('text-warning');
            else charPercentEl.classList.add('text-success');
        }

        segmentCountEl.classList.remove('text-success', 'text-warning', 'text-danger');
        if (pct > 90) segmentCountEl.classList.add('text-danger');
        else if (pct > 75) segmentCountEl.classList.add('text-warning');
        else segmentCountEl.classList.add('text-success');

        if (livePreviewEl) livePreviewEl.innerHTML = renderPreview(text);
    }

    templateValueInput.addEventListener('input', updateCounts);

    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            const text = livePreviewEl.innerText || livePreviewEl.textContent;
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({ icon: 'success', title: 'Copied!', text: 'Sample preview copied to clipboard.', timer: 1500, showConfirmButton: false });
            }).catch(() => {
                Swal.fire({ icon: 'error', title: 'Failed', text: 'Could not copy to clipboard.', confirmButtonColor: '#dc2626' });
            });
        });
    }

    // ---- Form submit ----
    const editForm = document.getElementById('editSmsForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('saveTemplateBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner-border');

            btnText.classList.add('d-none');
            spinner.classList.remove('d-none');
            submitBtn.disabled = true;

            const formData = new FormData(editForm);

            fetch('/admin/notifications/sms-templates/update', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Saved!', text: data.message, confirmButtonColor: '#16a34a' }).then(() => { window.location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: data.message || 'Something went wrong.', confirmButtonColor: '#dc2626' });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while saving.', confirmButtonColor: '#dc2626' });
            })
            .finally(() => {
                btnText.classList.remove('d-none');
                spinner.classList.add('d-none');
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<style>
    .tracking-wide { letter-spacing: 0.5px; }
    .icon-circle {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff; border-radius: 12px; font-size: 1.1rem;
        flex-shrink: 0;
    }
    .shadow-hover {
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    }
    .shadow-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08), 0 4px 8px rgba(0,0,0,0.04);
    }
    .preview-tabs .nav-pills .nav-link {
        color: #64748b; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px;
        font-size: 0.7rem; font-weight: 500; transition: all 0.2s;
    }
    .preview-tabs .nav-pills .nav-link.active {
        background: #6366f1; color: #fff; border-color: #6366f1;
    }
    .preview-tabs .nav-pills .nav-link:hover:not(.active) {
        background: #e2e8f0;
    }
    .preview-box {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
        padding: 10px 12px; min-height: 50px; max-height: 90px; overflow-y: auto;
    }
    .preview-sample {
        background: #fefce8; border-color: #fde68a;
    }
    .preview-sample small { color: #78350f !important; }
    .progress { background-color: #e2e8f0; border-radius: 99px; }
    .progress-bar { border-radius: 99px; transition: width 0.3s ease; }
    .ph-badge {
        display: inline-block;
        background: #eef2ff; color: #4338ca;
        font-size: 0.65rem; font-weight: 500;
        padding: 2px 8px; border-radius: 20px;
        border: 1px solid #c7d2fe;
        font-family: 'Courier New', monospace;
        transition: all 0.15s;
    }
    .ph-badge:hover {
        background: #4338ca; color: #fff; border-color: #4338ca;
    }
    .badge.bg-soft-success { background-color: #dcfce7 !important; color: #16a34a !important; }
    .badge.bg-soft-warning { background-color: #fef3c7 !important; color: #d97706 !important; }
    .badge.bg-soft-danger { background-color: #fee2e2 !important; color: #dc2626 !important; }
    .btn-outline-danger {
        border-color: #e2e8f0; color: #94a3b8; transition: all 0.2s;
    }
    .btn-outline-danger:hover {
        background-color: #fef2f2; border-color: #fecaca; color: #dc2626;
    }
    .form-check-input:checked { background-color: #16a34a; border-color: #16a34a; }
    .card .form-check-label { font-size: 0.6rem; color: #64748b; }
    .ph-insert-btn {
        border: 2px solid #6366f1; background: #eef2ff; color: #4338ca;
        font-family: 'Courier New', monospace; font-size: 0.85rem; font-weight: 600;
        padding: 6px 12px; border-radius: 8px; cursor: pointer; transition: all 0.2s;
        margin: 4px; display: inline-block;
    }
    .ph-insert-btn:hover {
        background: #6366f1; color: #fff; border-color: #4f46e5;
        transform: translateY(-2px); box-shadow: 0 4px 6px rgba(99, 102, 241, 0.3);
    }
    .ph-insert-btn:active { transform: translateY(0); box-shadow: none; }
    .sample-val {
        display: inline; background: #fef9c3; color: #92400e; padding: 0 3px; border-radius: 3px;
        border-bottom: 1px dashed #f59e0b;
    }
    .live-preview { max-height: 120px; overflow-y: auto; }
    .stats-card {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px;
    }
    .preview-box::-webkit-scrollbar { width: 3px; }
    .preview-box::-webkit-scrollbar-track { background: transparent; }
    .preview-box::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    .live-preview::-webkit-scrollbar { width: 3px; }
    .live-preview::-webkit-scrollbar-track { background: transparent; }
    .live-preview::-webkit-scrollbar-thumb { background: #d4a017; border-radius: 99px; }

    /* ===== SMS EDITOR SIDEBAR ===== */
    .sms-editor-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        visibility: hidden;
        pointer-events: none;
    }
    .sms-editor-sidebar.active {
        visibility: visible;
        pointer-events: all;
    }

    .sms-editor-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .sms-editor-sidebar.active .sms-editor-overlay {
        opacity: 1;
    }

    .sms-editor-panel {
        position: absolute;
        top: 0;
        right: 0;
        width: 560px;
        max-width: 100vw;
        height: 100%;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: -12px 0 40px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .sms-editor-sidebar.active .sms-editor-panel {
        transform: translateX(0);
    }

    .sms-editor-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 1.75rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    .sms-editor-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    @keyframes shimmer {
        0%, 100% { transform: translateX(-20%) rotate(0deg); }
        50% { transform: translateX(20%) rotate(5deg); }
    }
    .editor-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 14px;
        font-size: 1.4rem;
        color: #fff;
        flex-shrink: 0;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }
    .editor-close {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        color: #fff;
        font-size: 1.4rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(12px);
        position: relative;
        z-index: 1;
    }
    .editor-close:hover {
        background: rgba(255, 255, 255, 0.35);
        border-color: rgba(255, 255, 255, 0.5);
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    .editor-close:active {
        transform: rotate(90deg) scale(0.95);
    }

    .sms-editor-body {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        background: #fcfcfd;
        padding: 1.75rem;
    }
    .sms-editor-body::-webkit-scrollbar { width: 6px; }
    .sms-editor-body::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 99px; }
    .sms-editor-body::-webkit-scrollbar-thumb { 
        background: linear-gradient(180deg, #6366f1, #a855f7); 
        border-radius: 99px; 
    }
    .sms-editor-body::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #4f46e5, #9333ea);
    }

    .sms-editor-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1.25rem 1.75rem;
        border-top: 1px solid #e2e8f0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        flex-shrink: 0;
        position: relative;
    }
    .sms-editor-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #6366f1, transparent);
        opacity: 0.3;
    }
    .sms-editor-footer .btn {
        min-width: 140px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sms-editor-footer .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    .sms-editor-footer .btn:active {
        transform: translateY(0);
    }

    /* Enhanced form elements in sidebar */
    .sms-editor-body .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #ffffff;
    }
    .sms-editor-body .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        background: #ffffff;
    }
    .sms-editor-body .form-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9rem;
    }

    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .sms-editor-panel {
            width: 100vw;
        }
        .sms-editor-header {
            padding: 1.25rem 1.5rem;
        }
        .editor-icon {
            width: 42px;
            height: 42px;
            font-size: 1.2rem;
        }
        .editor-close {
            width: 36px;
            height: 36px;
            font-size: 1.2rem;
        }
        .sms-editor-body {
            padding: 1.25rem 1.5rem;
        }
        .sms-editor-footer {
            padding: 1rem 1.5rem;
            gap: 0.75rem;
        }
        .sms-editor-footer .btn {
            flex: 1;
            min-width: 0;
            padding: 0.75rem 1rem;
        }
    }
</style>
@endpush
@endsection