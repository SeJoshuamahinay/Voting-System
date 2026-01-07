@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('page-title', 'Activity Logs')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>System Activity Logs</h2>
            <div>
                <a href="{{ route('activity-logs.stats') }}" class="btn btn-info me-2">
                    <i class="bi bi-graph-up"></i> Statistics
                </a>
                <a href="{{ route('activity-logs.export', request()->query()) }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('activity-logs.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Search description..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Event Type</label>
                <select name="event" class="form-select">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                            {{ ucfirst($event) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">User</label>
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
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        
        @if(request()->hasAny(['search', 'event', 'user_id', 'date_from', 'date_to']))
            <div class="mt-2">
                <a href="{{ route('activity-logs.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Activity Logs Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th width="180">Date & Time</th>
                        <th width="100">Event</th>
                        <th width="150">User</th>
                        <th>Description</th>
                        <th width="120">IP Address</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>
                                <small>{{ $log->created_at->format('Y-m-d') }}</small><br>
                                <strong>{{ $log->created_at->format('H:i:s') }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-{{ $log->event_badge }}">
                                    <i class="{{ $log->event_icon }}"></i>
                                    {{ ucfirst($log->event) }}
                                </span>
                            </td>
                            <td>
                                @if($log->user)
                                    <a href="{{ route('users.show', $log->user_id) }}" class="text-decoration-none">
                                        {{ $log->user_name }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ $log->user_name }}</span>
                                @endif
                            </td>
                            <td>{{ $log->description }}</td>
                            <td><code>{{ $log->ip_address }}</code></td>
                            <td>
                                <a href="{{ route('activity-logs.show', $log) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No activity logs found.
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

<!-- Clear Old Logs Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('activity-logs.clear') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Clear Old Activity Logs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        This action will permanently delete old activity logs.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delete logs older than:</label>
                        <select name="days" class="form-select" required>
                            <option value="30">30 days</option>
                            <option value="60">60 days</option>
                            <option value="90" selected>90 days</option>
                            <option value="180">180 days</option>
                            <option value="365">1 year</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Clear Logs</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
        <i class="bi bi-trash"></i> Clear Old Logs
    </button>
</div>
@endsection
