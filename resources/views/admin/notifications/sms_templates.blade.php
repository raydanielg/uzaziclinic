@extends('admin.notifications.layout')

@section('notification_title', 'SMS Templates Management')
@section('notification_subtitle', 'Manage and customize your automated SMS messages')

@section('notification_content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="fw-bold text-dark small text-uppercase">Template Name</th>
                        <th class="fw-bold text-dark small text-uppercase">Description</th>
                        <th class="fw-bold text-dark small text-uppercase">Preview</th>
                        <th class="fw-bold text-dark small text-uppercase">Placeholders</th>
                        <th class="fw-bold text-dark small text-uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($realTemplates as $key => $template)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $template['title'] }}</div>
                            <small class="text-muted">{{ strtoupper(str_replace('sms_template_', '', $key)) }}</small>
                        </td>
                        <td>
                            <small class="text-muted">{{ $template['description'] }}</small>
                        </td>
                        <td>
                            <div class="text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ Str::limit($template['value'], 50) }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($template['placeholders'] as $ph)
                                <span class="badge bg-light text-dark border font-monospace" style="font-size: 0.7rem;">[{{ $ph }}]</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary rounded-2 me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editSmsModal" 
                                    data-key="{{ $key }}"
                                    data-title="{{ $template['title'] }}"
                                    data-description="{{ $template['description'] }}"
                                    data-value="{{ $template['value'] }}"
                                    data-placeholders='@json($template['placeholders'])'>
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-2" 
                                    onclick="resetTemplate('{{ $key }}', '{{ $template['title'] }}')">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
// Reset template to default value
function resetTemplate(key, title) {
    Swal.fire({
        title: 'Reset Template?',
        text: 'This will reset "' + title + '" to its default message. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Reset It',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("admin.notifications.resetSmsTemplate") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ key: key })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reset Complete',
                        text: 'Template has been reset to default',
                        confirmButtonColor: '#3b82f6'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to reset template');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Failed to reset template',
                    confirmButtonColor: '#dc2626'
                });
            });
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
            
            fetch('{{ route("admin.notifications.smsTemplates.update") }}', {
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
