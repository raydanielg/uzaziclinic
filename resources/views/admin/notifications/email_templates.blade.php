@extends('admin.notifications.layout')

@section('notification_title', 'Email Templates Management')
@section('notification_subtitle', 'Manage and customize your automated email messages with dynamic placeholders')

@section('notification_content')
<div class="row g-4">
    @foreach($emailTemplates as $key => $template)
    <div class="col-md-6 col-lg-4">
        <div class="card border border-light shadow-sm rounded-4 h-100 d-flex flex-column" style="background-color: #fdfdfd; transition: transform 0.2s; border-left: 4px solid #3b82f6 !important;">
            <div class="card-body p-4 d-flex flex-column h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 small fw-bold">Active</span>
                    <span class="small text-muted fw-semibold">ID: {{ strtoupper(str_replace('email_template_', '', $key)) }}</span>
                </div>
                
                <h5 class="fw-bold text-dark mb-2" style="font-size: 1.1rem;">{{ $template['title'] }}</h5>
                <p class="text-muted small mb-3 flex-grow-0" style="line-height: 1.4; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    {{ $template['description'] }}
                </p>

                <div class="bg-white p-3 rounded-3 border border-gray-100 mb-3 flex-grow-1" style="min-height: 100px; max-height: 150px; overflow-y: auto; background-color: #fafbfc !important;">
                    <p class="small mb-0 text-dark fw-medium" style="white-space: pre-line; line-height: 1.5;">{{ Str::limit($template['subject'], 80) }}</p>
                </div>

                <div class="mt-auto">
                    <div class="mb-3">
                        <span class="form-label d-block mb-1.5 fs-xs fw-bold text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">Placeholders:</span>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($template['placeholders'] as $ph)
                            <span class="badge bg-light text-dark border border-gray-200 rounded-pill font-monospace" style="font-size: 0.72rem; padding: 2px 8px;">{{ '{' . $ph . '}' }}</span>
                            @endforeach
                        </div>
                    </div>

                    <button class="btn btn-sm btn-outline-primary rounded-3 w-100 fw-bold py-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editEmailModal" 
                            data-key="{{ $key }}"
                            data-title="{{ $template['title'] }}"
                            data-description="{{ $template['description'] }}"
                            data-subject="{{ $template['subject'] }}"
                            data-body="{{ $template['body'] }}"
                            data-placeholders='@json($template['placeholders'])'>
                        <i class="fa-solid fa-pencil me-1.5"></i> Edit Template
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Add New Template Card --}}
    <div class="col-md-6 col-lg-4">
        <div class="card border-2 border-dashed rounded-4 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="border-color: #e5e7eb; background-color: #f9fafb; min-height: 300px;">
            <div class="bg-white text-primary p-4 rounded-circle mb-3 shadow-sm">
                <i class="fa-solid fa-plus fs-3"></i>
            </div>
            <h6 class="fw-bold mb-2 text-dark">Create New Template</h6>
            <p class="small text-muted mb-4">Add a custom email template for your communications</p>
            <button class="btn btn-primary rounded-3 fw-bold px-4" data-bs-toggle="modal" data-bs-target="#editEmailModal">
                <i class="fa-solid fa-plus me-2"></i> Add Template
            </button>
        </div>
    </div>
</div>

<!-- Edit Email Template Modal -->
<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="editEmailModalLabel">Edit Email Template</h5>
                    <p class="text-muted small mb-0" id="emailModalDescription"></p>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEmailForm">
                @csrf
                <input type="hidden" name="key" id="emailTemplateKey">
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-2 text-dark">Email Subject *</label>
                        <input type="text" class="form-control rounded-3 p-3 shadow-none" 
                               name="subject" 
                               id="emailTemplateSubject" 
                               style="border-color: #e5e7eb; transition: border-color 0.2s;" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold mb-2 text-dark">Email Body *</label>
                        <textarea class="form-control rounded-3 p-3 shadow-none" 
                                  name="body" 
                                  id="emailTemplateBody" 
                                  rows="8" 
                                  style="resize: vertical; font-size: 0.95rem; border-color: #e5e7eb; transition: border-color 0.2s;" 
                                  required></textarea>
                    </div>

                    <div class="alert alert-info rounded-3 border-0 bg-primary bg-opacity-10">
                        <small class="fw-bold"><i class="fa-solid fa-circle-info me-1"></i> Available Placeholders:</small>
                        <div class="mt-2 d-flex flex-wrap gap-1" id="emailPlaceholdersList">
                            <span class="badge bg-white text-dark border">No placeholders</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-3 fw-bold px-4 py-2.5" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveEmailTemplateBtn" class="btn btn-primary rounded-3 fw-bold px-4 py-2.5">
                        <span class="btn-text">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailTemplates = @json($emailTemplates ?? []);

    // Handle edit button click
    document.querySelectorAll('[data-bs-target="#editEmailModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;
            const title = this.dataset.title;
            const description = this.dataset.description;
            const subject = this.dataset.subject;
            const body = this.dataset.body;
            const placeholders = JSON.parse(this.dataset.placeholders || '[]');

            document.getElementById('editEmailModalLabel').textContent = key ? 'Edit Email Template' : 'Create New Template';
            document.getElementById('emailModalDescription').textContent = description || '';
            document.getElementById('emailTemplateKey').value = key || '';
            document.getElementById('emailTemplateSubject').value = subject || '';
            document.getElementById('emailTemplateBody').value = body || '';

            // Update placeholders list
            const placeholdersList = document.getElementById('emailPlaceholdersList');
            if (placeholders.length > 0) {
                placeholdersList.innerHTML = placeholders.map(ph => 
                    `<span class="badge bg-white text-dark border border-gray-200 font-monospace" style="font-size: 0.75rem;">{'{${ph}}'}</span>`
                ).join('');
            } else {
                placeholdersList.innerHTML = '<span class="badge bg-white text-dark border">No placeholders</span>';
            }
        });
    });

    // Handle form submission
    document.getElementById('editEmailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('saveEmailTemplateBtn');
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.spinner-border');
        
        btnText.classList.add('d-none');
        spinner.classList.remove('d-none');
        btn.disabled = true;

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        fetch('{{ route("admin.notifications.emailTemplates.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Email template updated successfully',
                    confirmButtonColor: '#3b82f6',
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(data.message || 'Failed to update template');
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.message || 'Failed to update email template',
                confirmButtonColor: '#dc2626',
            });
        })
        .finally(() => {
            btnText.classList.remove('d-none');
            spinner.classList.add('d-none');
            btn.disabled = false;
        });
    });
});
</script>
@endpush
@endsection
