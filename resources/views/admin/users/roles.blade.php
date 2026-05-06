@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold mb-0"><i class="fa-solid fa-shield-halved me-2"></i>Vyeo & Ruhusa (Roles)</h3>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left me-2"></i>Rudi Nyuma</a>
        </div>
    </div>

    <div class="row g-4">
        @foreach($roles as $role)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="stat-icon bg-primary-soft text-primary mx-auto mb-3" style="width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user-shield fa-2xl"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ ucfirst($role->name) }}</h5>
                    <p class="text-muted small mb-3">{{ $role->users_count }} Watumiaji</p>
                    
                    <div class="border-top pt-3 text-start">
                        <label class="small fw-bold text-muted mb-2 d-block">Permissions:</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php $perms = json_decode($role->permissions, true) @endphp
                            @if($perms)
                                @foreach($perms as $key => $val)
                                    <span class="badge bg-light text-dark border">{{ str_replace('_', ' ', $key) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted small italic text-center w-100">Hakuna permissions zilizowekwa.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
