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
    @endphp
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-hover rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <!-- Header: Icon + Toggle -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-circle">
                            <i class="fa-solid fa-comment-sms"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $template['title'] }}</h6>
                            <span class="badge bg-soft-{{ $barColor }} fw-normal px-2 py-1">
                                <i class="fa-regular fa-clock me-1"></i>{{ $segmentLabel }}
                            </span>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                               id="toggle_{{ $key }}" 
                               onchange="toggleTemplate('{{ $key }}', this.checked)"
                               {{ ($template['enabled'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-medium" for="toggle_{{ $key }}">
                            {{ ($template['enabled'] ?? true) ? 'Enabled' : 'Disabled' }}
                        </label>
                    </div>
                </div>
                
                <!-- Description -->
                <p class="text-muted small mb-3" style="font-size:0.8rem;">{{ $template['description'] }}</p>
                
                <!-- SMS Preview -->
                <div class="sms-preview mb-3">
                    <div class="preview-header d-flex justify-content-between align-items-center">
                        <small class="fw-bold text-uppercase tracking-wide">Message Preview</small>
                        <small class="text-muted">{{ $textLen }} / 160 chars</small>
                    </div>
                    <div class="preview-body">
                        <small class="text-muted" style="white-space: pre-line;">{{ Str::limit($template['value'], 180) }}</small>
                    </div>
                </div>
                
                <!-- Character Progress Bar -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span><i class="fa-regular fa-file-lines me-1"></i> Characters: <strong class="text-dark">{{ $textLen }}</strong></span>
                        <span><i class="fa-regular fa-rectangle-ad me-1"></i> Segments: <strong class="text-{{ $barColor }}">{{ $segmentLabel }}</strong></span>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-{{ $barColor }}" role="progressbar" 
                             style="width: {{ $charPercent }}%;" 
                             aria-valuenow="{{ $charPercent }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
                
                <!-- Placeholders -->
                <div class="mb-3">
                    <small class="text-muted fw-bold text-uppercase tracking-wide" style="font-size:0.65rem;">
                        <i class="fa-solid fa-tags me-1"></i> Placeholders:
                    </small>
                    <div class="d-flex flex-wrap gap-1 mt-1">
                        @foreach($template['placeholders'] as $ph)
                        <span class="badge bg-soft-secondary rounded-pill">[{{ $ph }}]</span>
                        @endforeach
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editSmsModal" 
                            data-key="{{ $key }}"
                            data-title="{{ $template['title'] }}"
                            data-description="{{ $template['description'] }}"
                            data-value="{{ $template['value'] }}"
                            data-placeholders='@json($template['placeholders'])'>
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                    </button>
                    <button class="btn btn-outline-danger reset-template" 
                            data-key="{{ $key }}"
                            data-title="{{ $template['title'] }}"
                            title="Reset to default">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Edit SMS Template Modal -->
<div class="modal fade" id="editSmsModal" tabindex="-1" aria-labelledby="editSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="editSmsModalLabel">Edit SMS Template</h5>
                    <p class="text-muted small mb-0" id="smsModalDescription"></p>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSmsForm">
                @csrf
                <input type="hidden" name="key" id="smsTemplateKey">
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-2 text-dark">SMS Content *</label>
                        <textarea class="form-control font-monospace border-2 rounded-3 p-3 shadow-none" 
                                  name="value" 
                                  id="smsTemplateValue" 
                                  rows="6" 
                                  style="resize: vertical; font-size: 0.95rem; border-color: #e5e7eb; transition: border-color 0.2s;" 
                                  required></textarea>
                    </div>

                    <!-- Insert Placeholders Widget -->
                    <div class="mb-3 bg-light p-3 rounded-3 border">
                        <span class="form-label d-block mb-2 fw-bold text-dark text-uppercase small" style="font-size: 0.75rem;"><i class="fa-solid fa-wand-magic-sparkles text-success me-1"></i> Quick Insert Placeholders</span>
                        <p class="text-muted small mb-2">Click on any placeholder below to insert it at your cursor's current position:</p>
                        <div class="d-flex flex-wrap gap-1.5" id="placeholdersContainer">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Live character & segment count -->
                    <div class="bg-light p-3 rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="form-label d-block mb-0 fw-bold text-dark text-uppercase small" style="font-size:0.7rem;">
                                <i class="fa-regular fa-file-lines me-1"></i> Message Stats
                            </span>
                            <span id="charPercent" class="fw-bold text-success small">0 / 160 chars</span>
                        </div>
                        <div class="progress mb-2" style="height: 5px;">
                            <div id="charProgress" class="progress-bar bg-success" role="progressbar" style="width: 0%;"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small">
                            <div>
                                Characters: <span id="charCount" class="fw-bold text-dark">0</span>
                            </div>
                            <div>
                                Segments: <span id="segmentCount" class="fw-bold text-success">1 Segment</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pb-4 px-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-3 fw-bold px-4 py-2.5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveTemplateBtn" class="btn btn-success rounded-3 fw-bold px-4 py-2.5">
                        <span class="btn-text">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Toggle template enabled/disabled
function toggleTemplate(key, enabled) {
    fetch('/admin/notifications/sms-templates/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ key: key, enabled: enabled })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const label = document.querySelector('label[for="toggle_' + key + '"]');
            if (label) {
                label.textContent = enabled ? 'Enabled' : 'Disabled';
            }
        } else {
            throw new Error(data.message || 'Failed to toggle template');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Failed to toggle template',
            confirmButtonColor: '#dc2626'
        });
        const toggle = document.getElementById('toggle_' + key);
        if (toggle) {
            toggle.checked = !enabled;
        }
    });
}

// Reset template to default
document.querySelectorAll('.reset-template').forEach(btn => {
    btn.addEventListener('click', function() {
        const key = this.getAttribute('data-key');
        const title = this.getAttribute('data-title');

        Swal.fire({
            title: 'Reset "' + title + '"?',
            text: 'This will restore the default message. Your custom message will be lost.',
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
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ key: key })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reset Complete',
                            text: data.message,
                            confirmButtonColor: '#16a34a'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Reset Failed',
                            text: data.message || 'Something went wrong.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while resetting the template.',
                        confirmButtonColor: '#dc2626'
                    });
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editSmsModal');
    const placeholdersContainer = document.getElementById('placeholdersContainer');
    const templateValueInput = document.getElementById('smsTemplateValue');
    const charCountEl = document.getElementById('charCount');
    const segmentCountEl = document.getElementById('segmentCount');
    const charProgressEl = document.getElementById('charProgress');
    const charPercentEl = document.getElementById('charPercent');

    function updateCounts() {
        const text = templateValueInput.value;
        const len = text.length;
        charCountEl.textContent = len;

        let segments = 1;
        if (len > 160) {
            segments = Math.ceil(len / 153);
        }
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
            charPercentEl.className = 'fw-bold';
            if (pct > 90) charPercentEl.classList.add('text-danger');
            else if (pct > 75) charPercentEl.classList.add('text-warning');
            else charPercentEl.classList.add('text-success');
        }

        segmentCountEl.classList.remove('text-success', 'text-warning');
        if (pct > 90) segmentCountEl.classList.add('text-danger');
        else if (pct > 75) segmentCountEl.classList.add('text-warning');
        else segmentCountEl.classList.add('text-success');
    }

    templateValueInput.addEventListener('input', updateCounts);

    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const key = button.getAttribute('data-key');
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const value = button.getAttribute('data-value');
            const placeholders = JSON.parse(button.getAttribute('data-placeholders'));

            document.getElementById('editSmsModalLabel').textContent = 'Edit: ' + title;
            document.getElementById('smsModalDescription').textContent = description;
            document.getElementById('smsTemplateKey').value = key;
            templateValueInput.value = value;

            placeholdersContainer.innerHTML = '';
            placeholders.forEach(ph => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-xs btn-outline-secondary font-monospace rounded-pill';
                btn.textContent = '[' + ph + ']';

                btn.addEventListener('click', function() {
                    const startPos = templateValueInput.selectionStart;
                    const endPos = templateValueInput.selectionEnd;
                    const placeholderText = '[' + ph + ']';
                    templateValueInput.value = templateValueInput.value.substring(0, startPos) + placeholderText + templateValueInput.value.substring(endPos);
                    templateValueInput.focus();
                    templateValueInput.selectionStart = templateValueInput.selectionEnd = startPos + placeholderText.length;
                    updateCounts();
                });

                placeholdersContainer.appendChild(btn);
            });

            updateCounts();
        });
    }

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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        confirmButtonColor: '#16a34a'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: data.message || 'Something went wrong.',
                        confirmButtonColor: '#16a34a'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving the template. Please try again.',
                    confirmButtonColor: '#16a34a'
                });
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
    .btn-xs { padding: 0.15rem 0.4rem; font-size: 0.75rem; }

    .icon-circle {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
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

    .sms-preview {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }
    .sms-preview .preview-header {
        background: #f1f5f9;
        padding: 6px 12px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.65rem;
    }
    .sms-preview .preview-body {
        padding: 10px 12px;
        min-height: 48px;
        max-height: 80px;
        overflow-y: auto;
    }
    .sms-preview .preview-body small {
        font-size: 0.78rem !important;
        line-height: 1.4;
    }

    .progress { background-color: #e2e8f0; border-radius: 99px; }
    .progress-bar { border-radius: 99px; transition: width 0.3s ease; }

    .badge.bg-soft-secondary {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 0.65rem;
        font-weight: 500;
    }
    .badge.bg-soft-success {
        background-color: #dcfce7 !important;
        color: #16a34a !important;
    }
    .badge.bg-soft-warning {
        background-color: #fef3c7 !important;
        color: #d97706 !important;
    }
    .badge.bg-soft-danger {
        background-color: #fee2e2 !important;
        color: #dc2626 !important;
    }

    .btn-outline-danger {
        border-color: #e2e8f0;
        color: #94a3b8;
        transition: all 0.2s;
    }
    .btn-outline-danger:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }
    .btn-outline-danger i { font-size: 0.9rem; }

    .form-check-input:checked {
        background-color: #16a34a;
        border-color: #16a34a;
    }
    .card .form-check-label {
        font-size: 0.7rem;
        color: #64748b;
    }

    /* Custom scrollbar for preview */
    .preview-body::-webkit-scrollbar { width: 3px; }
    .preview-body::-webkit-scrollbar-track { background: transparent; }
    .preview-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
</style>
@endpush
@endsection
