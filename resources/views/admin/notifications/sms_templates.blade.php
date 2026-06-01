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
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden sms-card" id="card-{{ $key }}">
            <div class="card-body p-4 d-flex flex-column h-100">
                <!-- Header (Always visible) -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="icon-circle" style="background: {{ $iconBg }}; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.15);">
                            <i class="fa-solid {{ $icon }} fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 0.95rem; max-width: 170px;">{{ $template['title'] }}</h6>
                            <span class="badge bg-soft-indigo fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.65rem; color: #4f46e5; background-color: #f5f3ff;">
                                {{ strtoupper(str_replace('sms_template_', '', $key)) }}
                            </span>
                        </div>
                    </div>
                    <div class="form-check form-switch p-0 m-0 d-flex align-items-center gap-1.5">
                        <input class="form-check-input ms-0" type="checkbox"
                               id="toggle_{{ $key }}"
                               onchange="toggleTemplate('{{ $key }}', this.checked)"
                               {{ ($template['enabled'] ?? true) ? 'checked' : '' }}
                               style="cursor: pointer; width: 2.2em; height: 1.1em;">
                        <label class="form-check-label small fw-bold text-muted" for="toggle_{{ $key }}" id="toggle_label_{{ $key }}" style="font-size: 0.65rem; width: 45px;">
                            {{ ($template['enabled'] ?? true) ? 'Active' : 'Off' }}
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-muted mb-3" style="font-size:0.78rem; line-height:1.4; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    {{ $template['description'] }}
                </p>

                <!-- VIEW CONTAINER -->
                <div class="view-container flex-grow-1 d-flex flex-column" id="view-container-{{ $key }}">
                    <!-- SMS Chat Bubble Preview -->
                    <div class="sms-thread-container mb-3 flex-grow-1">
                        <div class="sms-bubble-sender">
                            <i class="fa-solid fa-circle-check text-primary me-1"></i>UZAZI CLINIC
                        </div>
                        <div class="sms-bubble">
                            <span class="sms-bubble-text text-dark font-monospace" style="font-size: 0.8rem; line-height: 1.5; white-space: pre-line;">
                                {!! preg_replace('/\[(.*?)\]/', '<span class="sample-val-highlight">$1</span>', $template['value']) !!}
                            </span>
                        </div>
                        <div class="sms-bubble-time">
                            <i class="fa-solid fa-check-double text-primary me-1"></i>Delivered • Just now
                        </div>
                    </div>

                    <!-- Progress Stats -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-1" style="font-size: 0.7rem;">
                            <span><i class="fa-regular fa-file-lines me-1"></i> Characters: <strong class="text-dark">{{ $textLen }}</strong></span>
                            <span><i class="fa-regular fa-clone me-1"></i> Segments: <strong class="text-{{ $barColor }}">{{ $segmentLabel }}</strong></span>
                        </div>
                        <div class="progress" style="height: 5px; border-radius: 10px;">
                            <div class="progress-bar bg-{{ $barColor }}" role="progressbar" style="width: {{ $charPercent }}%;"></div>
                        </div>
                    </div>

                    <!-- Placeholders (View mode) -->
                    <div class="mb-4">
                        <span class="d-block text-uppercase text-muted fw-bold mb-1.5" style="font-size: 0.6rem; letter-spacing: 0.5px;">Placeholders:</span>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($template['placeholders'] as $ph)
                            <span class="badge bg-light text-secondary border rounded-pill font-monospace" style="font-size: 0.65rem; padding: 2.5px 8px;">[{{ $ph }}]</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- View Action Buttons -->
                    <div class="mt-auto d-flex gap-2">
                        <button class="btn btn-primary flex-fill rounded-3 fw-bold py-2.5 shadow-sm transition-all" onclick="startInlineEdit('{{ $key }}')" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none; font-size: 0.825rem;">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Template
                        </button>
                        <button class="btn btn-outline-danger rounded-3 py-2.5 px-3 reset-template border-2" data-key="{{ $key }}" data-title="{{ $template['title'] }}" title="Reset to Default" style="font-size: 0.825rem;">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                    </div>
                </div>

                <!-- EDIT CONTAINER (Hidden by default) -->
                <div class="edit-container flex-grow-1 d-none flex-column" id="edit-container-{{ $key }}">
                    <!-- Textarea Editor -->
                    <div class="mb-3 position-relative">
                        <textarea class="form-control font-monospace border-2 rounded-3 p-3 shadow-none text-dark inline-editor-textarea"
                                  id="textarea-{{ $key }}"
                                  rows="5"
                                  style="resize: none; font-size: 0.825rem; border-color: #cbd5e1; background: #fff; line-height: 1.45;"
                                  oninput="updateInlineCounts('{{ $key }}')">{{ $template['value'] }}</textarea>
                    </div>

                    <!-- Edit Stats -->
                    <div class="stats-card p-2.5 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="d-flex justify-content-between text-muted mb-1" style="font-size: 0.7rem;">
                            <span>Chars: <strong class="text-dark" id="char-count-{{ $key }}">0</strong> / 160</span>
                            <span id="segment-count-{{ $key }}" class="fw-bold text-success">1 Segment</span>
                        </div>
                        <div class="progress" style="height: 4px; border-radius: 10px;">
                            <div id="progress-bar-{{ $key }}" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Insert Placeholders Widget -->
                    <div class="mb-3">
                        <span class="d-block text-uppercase text-muted fw-bold mb-1.5" style="font-size: 0.6rem; letter-spacing: 0.5px;">Click to Insert Placeholder:</span>
                        <div class="d-flex flex-wrap gap-1.5">
                            @foreach($template['placeholders'] as $ph)
                            <button type="button" class="btn btn-xs ph-insert-button rounded-3 bg-white border font-monospace transition-all" 
                                    style="font-size: 0.68rem; font-weight: 600; border-color: #6366f1; color: #4338ca; padding: 4px 10px;"
                                    onclick="insertPlaceholder('{{ $key }}', '{{ $ph }}')">
                                <i class="fa-solid fa-plus small me-1"></i>[{{ $ph }}]
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Live Sample Preview Bubble Mockup -->
                    <div class="sms-thread-container mb-3 flex-grow-1" style="background-color: #fffef2 !important; border: 1px solid #fef08a;">
                        <div class="sms-bubble-sender" style="color: #a16207;">
                            <i class="fa-solid fa-circle-notch fa-spin text-warning me-1"></i>UZAZI CLINIC • LIVE PREVIEW
                        </div>
                        <div class="sms-bubble" style="background: #fef9c3; border: 1px solid #fde047;">
                            <span id="preview-{{ $key }}" class="sms-bubble-text small text-dark font-monospace d-block" style="font-size:0.75rem; line-height:1.45; white-space:pre-line;">
                                Start typing...
                            </span>
                        </div>
                        <div class="sms-bubble-time" style="color: #a16207;">
                            <i class="fa-regular fa-clock me-1"></i>Draft updating...
                        </div>
                    </div>

                    <!-- Save & Cancel Actions -->
                    <div class="mt-auto d-flex gap-2">
                        <button class="btn btn-success flex-fill rounded-3 fw-bold py-2.5 shadow-sm transition-all" onclick="saveInlineTemplate('{{ $key }}')" id="save-btn-{{ $key }}" style="font-size: 0.825rem; background: linear-gradient(135deg, #10b981, #059669); border: none;">
                            <span class="btn-text" id="btn-text-{{ $key }}"><i class="fa-regular fa-floppy-disk me-1"></i> Save Changes</span>
                            <span class="spinner-border spinner-border-sm d-none" id="spinner-{{ $key }}" role="status" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-light rounded-3 fw-bold py-2.5 px-3.5 transition-all" onclick="cancelInlineEdit('{{ $key }}')" style="font-size: 0.825rem; border: 2px solid #e2e8f0; background: #fff;">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const sampleData = {
    patient_name: 'John Doe',
    patient_ID: 'UZC-001234',
    doctor_name: 'Dr. Mlay',
    appointment_date: '15/06/2026',
    appointment_time: '10:30 AM',
    service_name: 'General Checkup',
    amount: '25,000',
    payment_type: 'Vipimo',
    booking_id: 'BK-9938',
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

// Render previews with custom highlight style
function renderPreviewText(text) {
    let rendered = text;
    Object.keys(sampleData).forEach(ph => {
        const regex = new RegExp('\\[' + ph + '\\]', 'g');
        rendered = rendered.replace(regex, '<span class="sample-val-highlight">' + sampleData[ph] + '</span>');
    });
    return rendered || '<span style="color:#94a3b8;font-style:italic;">Start typing to see preview...</span>';
}

// Start Editing inline
function startInlineEdit(key) {
    document.getElementById('view-container-' + key).classList.add('d-none');
    document.getElementById('edit-container-' + key).classList.remove('d-none');
    
    // Auto-focus the textarea
    const textarea = document.getElementById('textarea-' + key);
    textarea.focus();
    
    // Run counts initially
    updateInlineCounts(key);
}

// Cancel Editing inline
function cancelInlineEdit(key) {
    document.getElementById('edit-container-' + key).classList.add('d-none');
    document.getElementById('view-container-' + key).classList.remove('d-none');
}

// Live counts & previews
function updateInlineCounts(key) {
    const textarea = document.getElementById('textarea-' + key);
    const charCountEl = document.getElementById('char-count-' + key);
    const segmentCountEl = document.getElementById('segment-count-' + key);
    const progressBar = document.getElementById('progress-bar-' + key);
    const previewBox = document.getElementById('preview-' + key);
    const saveBtn = document.getElementById('save-btn-' + key);
    const btnText = document.getElementById('btn-text-' + key);

    if (!textarea) return;

    const len = textarea.value.length;
    charCountEl.textContent = len;

    // SMS Segment count
    let segments = 1;
    if (len > 160) segments = Math.ceil(len / 153);
    segmentCountEl.textContent = segments + (segments === 1 ? ' Segment' : ' Segments');

    const pct = Math.min(100, (len / 160) * 100);
    progressBar.style.width = pct + '%';
    progressBar.className = 'progress-bar';

    // Color code segment
    if (pct > 90) {
        progressBar.classList.add('bg-danger');
        segmentCountEl.className = 'fw-bold text-danger';
    } else if (pct > 75) {
        progressBar.classList.add('bg-warning');
        segmentCountEl.className = 'fw-bold text-warning';
    } else {
        progressBar.classList.add('bg-success');
        segmentCountEl.className = 'fw-bold text-success';
    }

    // Render Preview
    previewBox.innerHTML = renderPreviewText(textarea.value);

    // Detect Changes & Update Button state
    const isChanged = (textarea.value !== textarea.getAttribute('data-original'));
    if (saveBtn && btnText) {
        if (isChanged) {
            saveBtn.disabled = false;
            saveBtn.classList.remove('btn-secondary');
            saveBtn.classList.add('btn-success');
            saveBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            saveBtn.style.pointerEvents = 'auto';
            btnText.innerHTML = '<i class="fa-solid fa-cloud-arrow-up me-1"></i> Update Template';
        } else {
            saveBtn.disabled = true;
            saveBtn.classList.remove('btn-success');
            saveBtn.classList.add('btn-secondary');
            saveBtn.style.background = '#94a3b8';
            saveBtn.style.pointerEvents = 'none';
            btnText.innerHTML = '<i class="fa-solid fa-check me-1"></i> Up to Date';
        }
    }
}

// Insert Placeholders in textareas
function insertPlaceholder(key, ph) {
    const textarea = document.getElementById('textarea-' + key);
    if (!textarea) return;

    const startPos = textarea.selectionStart;
    const endPos = textarea.selectionEnd;
    const phText = '[' + ph + ']';

    textarea.value = textarea.value.substring(0, startPos) + phText + textarea.value.substring(endPos);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = startPos + phText.length;
    
    updateInlineCounts(key);
}

// Save Template inline
function saveInlineTemplate(key) {
    const textarea = document.getElementById('textarea-' + key);
    const saveBtn = document.getElementById('save-btn-' + key);
    const btnText = document.getElementById('btn-text-' + key);
    const spinner = document.getElementById('spinner-' + key);

    if (!textarea || !saveBtn) return;

    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    saveBtn.disabled = true;

    // Use FormData for standard, bulletproof Laravel POST parsing
    const formData = new FormData();
    formData.append('key', key);
    formData.append('value', textarea.value);

    fetch('/admin/notifications/sms-templates/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Template Updated!',
                text: data.message,
                confirmButtonColor: '#6366f1',
                timer: 2000
            }).then(() => {
                window.location.reload();
            });
        } else {
            throw new Error(data.message || 'Failed to update template');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Failed to save template',
            confirmButtonColor: '#dc2626'
        });
    })
    .finally(() => {
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
        saveBtn.disabled = false;
    });
}

// Toggle enabled/disabled state via switch
function toggleTemplate(key, enabled) {
    const toggle = document.getElementById('toggle_' + key);
    const label = document.getElementById('toggle_label_' + key);

    fetch('/admin/notifications/sms-templates/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ key: key, enabled: enabled })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (label) label.textContent = enabled ? 'Active' : 'Off';
            
            // Success micro-toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: enabled ? 'Template Enabled!' : 'Template Disabled!'
            });
        } else {
            throw new Error();
        }
    })
    .catch(() => {
        if (toggle) toggle.checked = !enabled;
        if (label) label.textContent = !enabled ? 'Active' : 'Off';
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: 'Could not toggle template status.',
            confirmButtonColor: '#dc2626'
        });
    });
}

// Reset template defaults
document.querySelectorAll('.reset-template').forEach(btn => {
    btn.addEventListener('click', function() {
        const key = this.getAttribute('data-key');
        const title = this.getAttribute('data-title');

        Swal.fire({
            title: 'Reset "' + title + '"?',
            html: 'This will restore the <strong>default message</strong>.<br>Your custom edits will be overwritten.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Reset It',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/admin/notifications/sms-templates/reset', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ key: key })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reset Completed',
                            text: data.message,
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error();
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while resetting.',
                        confirmButtonColor: '#dc2626'
                    });
                });
            }
        });
    });
});
</script>

<style>
    .sms-card {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }
    .sms-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important;
    }
    .sample-val-highlight {
        display: inline-block;
        background: #fef9c3;
        color: #92400e;
        padding: 0 4px;
        border-radius: 4px;
        border-bottom: 2px dashed #f59e0b;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .progress {
        background-color: #f1f5f9;
        overflow: hidden;
    }
    .progress-bar {
        transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .form-check-input:checked {
        background-color: #10b981 !important;
        border-color: #10b981 !important;
    }

    /* ===== SMS CHAT BUBBLE STYLES ===== */
    .sms-thread-container {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .sms-bubble-sender {
        font-size: 0.65rem;
        font-weight: 800;
        color: #64748b;
        margin-bottom: 6px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
    }
    .sms-bubble {
        background-color: #e2e8f0;
        border-radius: 16px;
        border-top-left-radius: 4px;
        padding: 10px 14px;
        color: #1e293b;
        font-size: 0.8rem;
        max-width: 90%;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        align-self: flex-start;
    }
    .sms-bubble-time {
        font-size: 0.625rem;
        color: #94a3b8;
        margin-top: 6px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    /* ===== TEXTAREA & INTERACTIVE BUTTONS ===== */
    .inline-editor-textarea {
        border: 2px solid #cbd5e1;
        transition: all 0.25s ease;
        background-color: #fff;
    }
    .inline-editor-textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
        background-color: #fff;
    }
    .ph-insert-button {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .ph-insert-button:hover {
        background-color: #6366f1 !important;
        color: #fff !important;
        border-color: #6366f1 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);
    }
    .ph-insert-button:active {
        transform: translateY(0);
    }

    /* Transitions */
    .transition-all {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush
@endsection