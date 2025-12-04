@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Users Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="mb-1">{{ $stats['total_users'] }}</h3>
            <p class="text-muted mb-0">Total Users</p>
        </div>
    </div>

    <!-- Total Roles Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-shield-check"></i>
            </div>
            <h3 class="mb-1">{{ $stats['total_roles'] }}</h3>
            <p class="text-muted mb-0">Total Roles</p>
        </div>
    </div>

    <!-- Total Permissions Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-key"></i>
            </div>
            <h3 class="mb-1">{{ $stats['total_permissions'] }}</h3>
            <p class="text-muted mb-0">Total Permissions</p>
        </div>
    </div>

    <!-- Active Sessions Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="bi bi-check2-square"></i>
            </div>
            <h3 class="mb-1">0</h3>
            <p class="text-muted mb-0">Active Votes</p>
        </div>
    </div>
</div>

<!-- Recent Activity and Quick Actions -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('roles.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create New Role
                    </a>
                    <a href="{{ route('permissions.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>Create New Permission
                    </a>
                    <a href="{{ route('voting') }}" class="btn btn-outline-info">
                        <i class="bi bi-check2-square me-2"></i>Go to Voting
                    </a>
                    <a href="{{ route('results') }}" class="btn btn-outline-warning">
                        <i class="bi bi-bar-chart me-2"></i>View Results
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-plus text-primary me-2"></i>Recent Users</h5>
                <span class="badge bg-primary">{{ $stats['total_users'] }} Total</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th>Roles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stats['recent_users'] as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2" style="width: 32px; height: 32px; font-size: 14px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-secondary">No Role</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('styles')
<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
    }
</style>
@endsection
