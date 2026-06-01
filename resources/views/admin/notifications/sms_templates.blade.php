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

                    <!-- Live word & segment count -->
                    <div class="d-flex justify-content-between align-items-center bg-gray-50 p-2 rounded-2 border border-gray-100 text-muted small">
                        <div>
                            Characters: <span id="charCount" class="fw-bold text-dark">0</span>
                        </div>
                        <div>
                            Estimated Segments: <span id="segmentCount" class="fw-bold text-success">1 Segment</span> (160 chars max per segment)
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
            // Update label
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
        // Revert toggle
        const toggle = document.getElementById('toggle_' + key);
        if (toggle) {
            toggle.checked = !enabled;
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editSmsModal');
    const placeholdersContainer = document.getElementById('placeholdersContainer');
    const templateValueInput = document.getElementById('smsTemplateValue');
    const charCountEl = document.getElementById('charCount');
    const segmentCountEl = document.getElementById('segmentCount');
    
    // Live count updates
    function updateCounts() {
        const text = templateValueInput.value;
        const len = text.length;
        charCountEl.textContent = len;
        
        // SMS segment logic: 1st segment is 160. Multipart SMS segment is 153 chars.
        let segments = 1;
        if (len > 160) {
            segments = Math.ceil(len / 153);
        }
        segmentCountEl.textContent = segments + (segments === 1 ? ' Segment' : ' Segments');
        
        if (len > 160) {
            segmentCountEl.classList.remove('text-success');
            segmentCountEl.classList.add('text-warning');
        } else {
            segmentCountEl.classList.remove('text-warning');
            segmentCountEl.classList.add('text-success');
        }
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
            
            // Populate modal fields
            document.getElementById('editSmsModalLabel').textContent = 'Edit: ' + title;
            document.getElementById('smsModalDescription').textContent = description;
            document.getElementById('smsTemplateKey').value = key;
            templateValueInput.value = value;
            
            // Generate quick-insert placeholder buttons
            placeholdersContainer.innerHTML = '';
            placeholders.forEach(ph => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-xs btn-outline-dark font-monospace rounded-pill text-dark border-gray-300 hover-bg-success hover-text-white transition';
                btn.style.fontSize = '0.75rem';
                btn.style.padding = '3px 10px';
                btn.style.margin = '2px';
                btn.textContent = '[' + ph + ']';
                
                btn.addEventListener('click', function() {
                    // Insert at current cursor position in textarea
                    const startPos = templateValueInput.selectionStart;
                    const endPos = templateValueInput.selectionEnd;
                    const text = templateValueInput.value;
                    const placeholderText = '[' + ph + ']';
                    
                    templateValueInput.value = text.substring(0, startPos) + placeholderText + text.substring(endPos);
                    templateValueInput.focus();
                    templateValueInput.selectionStart = templateValueInput.selectionEnd = startPos + placeholderText.length;
                    
                    updateCounts();
                });
                
                placeholdersContainer.appendChild(btn);
            });
            
            updateCounts();
        });
    }

    // Handle form submit via AJAX
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
            .catch(error => {
                console.error(error);
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
    .btn-xs {
        padding: 0.15rem 0.4rem;
        font-size: 0.75rem;
    }
    .hover-bg-success:hover {
        background-color: #16a34a !important;
        border-color: #16a34a !important;
    }
    .hover-text-white:hover {
        color: white !important;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
</style>
@endpush
@endsection
