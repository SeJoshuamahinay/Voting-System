@extends('layouts.admin')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>User Details</h3>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="user-avatar mx-auto" style="width: 80px; height: 80px; font-size: 32px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Email Verified</th>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                                <small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                            @else
                                <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Groups</th>
                        <td>
                            @if($user->groups->count() > 0)
                                @foreach($user->groups as $group)
                                    <span class="badge bg-success me-1">{{ $group->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No groups assigned</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $user->updated_at->format('M d, Y H:i:s') }}</td>
                    </tr>
                </table>

                <h4 class="mt-4">Assigned Roles ({{ $user->roles->count() }})</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user->roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td><code>{{ $role->slug }}</code></td>
                                    <td>{{ $role->description ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $role->permissions->count() }} permissions</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No roles assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h4 class="mt-4">Assigned Groups ({{ $user->groups->count() }})</h4>
                @if($user->groups->count() > 0)
                    <div class="row">
                        @foreach($user->groups as $group)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-collection text-success me-2"></i>
                                            {{ $group->name }}
                                        </h5>
                                        @if($group->description)
                                            <p class="card-text text-muted">{{ $group->description }}</p>
                                        @endif
                                        <small class="text-muted">
                                            <i class="bi bi-people"></i> {{ $group->users->count() }} member(s)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No groups assigned to this user.</p>
                @endif

                @if($user->roles->count() > 0)
                    <h4 class="mt-4">All Permissions</h4>
                    <div class="row">
                        @php
                            $allPermissions = $user->roles->flatMap->permissions->unique('id');
                        @endphp
                        @forelse ($allPermissions as $permission)
                            <div class="col-md-6 mb-2">
                                <div class="card">
                                    <div class="card-body py-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>{{ $permission->name }}</strong>
                                        @if($permission->description)
                                            <br><small class="text-muted ms-4">{{ $permission->description }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No permissions granted.</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 32px;
    }
</style>
@endsection
