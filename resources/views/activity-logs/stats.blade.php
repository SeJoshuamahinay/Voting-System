@extends('layouts.admin')

@section('title', 'Activity Log Statistics')

@section('page-title', 'Activity Log Statistics')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Activity Statistics</h2>
            <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Logs
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-activity"></i>
            </div>
            <h3 class="mb-1">{{ number_format($stats['total_logs']) }}</h3>
            <p class="text-muted mb-0">Total Logs</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-calendar-day"></i>
            </div>
            <h3 class="mb-1">{{ number_format($stats['today_logs']) }}</h3>
            <p class="text-muted mb-0">Today's Logs</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-calendar-week"></i>
            </div>
            <h3 class="mb-1">{{ number_format($stats['this_week_logs']) }}</h3>
            <p class="text-muted mb-0">This Week</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-calendar-month"></i>
            </div>
            <h3 class="mb-1">{{ number_format($stats['this_month_logs']) }}</h3>
            <p class="text-muted mb-0">This Month</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Events Breakdown -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart text-primary me-2"></i>Events Breakdown</h5>
            </div>
            <div class="card-body">
                @if($stats['events_breakdown']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th class="text-end">Count</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['events_breakdown'] as $event)
                                    @php
                                        $percentage = ($event->count / $stats['total_logs']) * 100;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($event->event) }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ number_format($event->count) }}</td>
                                        <td class="text-end">
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $percentage }}%">
                                                    {{ number_format($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Users -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-people text-success me-2"></i>Most Active Users</h5>
            </div>
            <div class="card-body">
                @if($stats['top_users']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>User</th>
                                    <th class="text-end">Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['top_users'] as $index => $user)
                                    <tr>
                                        <td>
                                            @if($index === 0)
                                                <span class="badge bg-warning">🥇</span>
                                            @elseif($index === 1)
                                                <span class="badge bg-secondary">🥈</span>
                                            @elseif($index === 2)
                                                <span class="badge bg-danger">🥉</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->user_id)
                                                <a href="{{ route('users.show', $user->user_id) }}">
                                                    {{ $user->user_name }}
                                                </a>
                                            @else
                                                {{ $user->user_name }}
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($user->count) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
