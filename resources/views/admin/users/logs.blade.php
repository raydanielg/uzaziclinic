@extends('layouts.admin')

@section('page_title', 'Security Audit Logs')

@section('content')
<div class="row animate__animated animate__fadeInUp">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Security Audit Logs</h5>
                <div class="text-muted small">Latest system actions and access events</div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Target</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="text-muted">{{ optional($log->created_at)->format('d M, Y H:i') }}</td>
                                <td class="fw-semibold">{{ $log->user->name ?? 'System' }}</td>
                                <td>{{ $log->action }}</td>
                                <td class="text-muted">
                                    {{ $log->auditable_type ? class_basename($log->auditable_type) : 'N/A' }}
                                    @if($log->auditable_id)
                                        #{{ $log->auditable_id }}
                                    @endif
                                </td>
                                <td class="text-muted">{{ $log->ip_address ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-shield-halved fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">No audit logs found yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
