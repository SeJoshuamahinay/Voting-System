@extends('layouts.admin')

@section('title', 'Activity Log Details')

@section('page-title', 'Activity Log Details')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Activity Log #{{ $activityLog->id }}</h4>
                <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $activityLog->id }}</td>
                    </tr>
                    <tr>
                        <th>Event Type</th>
                        <td>
                            <span class="badge bg-{{ $activityLog->event_badge }} fs-6">
                                <i class="{{ $activityLog->event_icon }}"></i>
                                {{ ucfirst($activityLog->event) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $activityLog->description }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>
                            @if($activityLog->user)
                                <a href="{{ route('users.show', $activityLog->user_id) }}">
                                    {{ $activityLog->user_name }}
                                </a>
                            @else
                                {{ $activityLog->user_name ?? 'System' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>
                            @if($activityLog->subject_type)
                                {{ class_basename($activityLog->subject_type) }} #{{ $activityLog->subject_id }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>IP Address</th>
                        <td><code>{{ $activityLog->ip_address }}</code></td>
                    </tr>
                    <tr>
                        <th>User Agent</th>
                        <td><small>{{ $activityLog->user_agent }}</small></td>
                    </tr>
                    <tr>
                        <th>Date & Time</th>
                        <td>{{ $activityLog->created_at->format('F d, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Time Ago</th>
                        <td>{{ $activityLog->created_at->diffForHumans() }}</td>
                    </tr>
                </table>

                @if($activityLog->properties)
                    <h5 class="mt-4">Additional Properties</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            <pre class="mb-0">{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
