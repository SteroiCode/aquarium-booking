@extends('admin.layout')

@section('content')
<h2 class="mb-4"><i class="bi bi-clock-history"></i> Activity Logs</h2>

<!-- Filters -->
<div class="card p-4 mb-4">
    <form method="GET" action="{{ route('admin.activity_logs.index') }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-dark">Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-dark">User</label>
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label text-dark">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background: linear-gradient(135deg,#0ea5e9,#06b6d4);">
                <tr>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Time</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">User</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Action</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Description</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">IP Address</th>
                    <th style="color:#ffffff !important; background: linear-gradient(135deg,#0ea5e9,#06b6d4) !important; border:none !important; font-weight:700; text-transform:uppercase; font-size:13px; padding:14px 16px;">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>
                        <small>{{ $log->created_at->format('M d, Y') }}</small><br>
                        <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                    </td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>
                        <span class="badge 
                            @if($log->action === 'create') bg-success
                            @elseif($log->action === 'update') bg-info
                            @elseif($log->action === 'delete') bg-danger
                            @elseif($log->action === 'export') bg-warning
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                    <td>
                        @if($log->changes)
                            <button class="btn btn-sm btn-outline-info" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#logModal{{ $log->id }}">
                                <i class="bi bi-eye"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-dark text-light">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Change Details</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <pre class="text-light">{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mt-2">No activity logs found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>
@endsection
