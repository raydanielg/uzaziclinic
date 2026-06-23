@props(['files', 'type' => 'patient'])

@if($files->isNotEmpty())
<div class="row g-2">
    @foreach($files as $f)
    @php
        $isImage = str($f->file_type)->contains('image') || str($f->file_name)->endsWith(['.jpg','.jpeg','.png']);
        $isPdf   = str($f->file_type)->contains('pdf') || str($f->file_name)->endsWith('.pdf');
        $icon    = $isImage ? 'fa-image' : ($isPdf ? 'fa-file-pdf' : 'fa-file');
        $color   = $isImage ? 'text-green'  : ($isPdf ? 'text-rose' : 'text-blue');
        $bg      = $isImage ? 'bg-green-soft' : ($isPdf ? 'bg-rose-soft' : 'bg-blue-soft');
        $routeView   = $type === 'patient' ? route('shared.patient-files.view', $f) : route('shared.lab-result-files.view', $f);
        $routeDownload = $type === 'patient' ? route('shared.patient-files.download', $f) : route('shared.lab-result-files.download', $f);
    @endphp
    <div class="col-md-6">
        <div class="d-flex align-items-center gap-2 p-2 rounded-2 border {{ $bg }} mb-2">
            <div class="flex-shrink-0">
                <i class="fa-solid {{ $icon }} {{ $color }} fs-4"></i>
            </div>
            <div class="flex-grow-1 min-width-0">
                <div class="fw-semibold small text-truncate" title="{{ $f->file_name }}">{{ $f->file_name }}</div>
                <div class="text-muted" style="font-size:.7rem">{{ $f->file_type_label ?? ucfirst($f->file_type) }} &middot; {{ $f->file_size }} &middot; {{ $f->uploadedBy->name ?? 'System' }}</div>
            </div>
            <div class="flex-shrink-0 d-flex gap-1">
                <a href="{{ $routeView }}" target="_blank" class="btn btn-sm btn-light rounded-2" title="View">
                    <i class="fa-solid fa-eye text-blue"></i>
                </a>
                <a href="{{ $routeDownload }}" class="btn btn-sm btn-light rounded-2" title="Download">
                    <i class="fa-solid fa-download text-green"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-3 text-muted small">
    <i class="fa-solid fa-folder-open opacity-25 d-block mb-2 fs-4"></i>
    Hakuna faili zilizopakiwa
</div>
@endif
