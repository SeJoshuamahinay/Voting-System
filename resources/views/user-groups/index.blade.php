@extends('layouts.app')

@section('title', 'User Groups Management')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-3">User Groups Management</h1>
                    <p class="text-muted">Manage which groups each user belongs to</p>
                </div>
                <a href="{{ route('user-groups.api-docs') }}" class="btn btn-outline-info">
                    <i class="bi bi-file-code"></i> API Documentation
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-people"></i> Users and Their Groups</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Groups</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->groups->count() > 0)
                                        @foreach($user->groups as $group)
                                            <span class="badge bg-info text-dark me-1">
                                                <i class="bi bi-collection"></i> {{ $group->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No groups assigned</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('user-groups.edit', $user->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit Groups
                                    </a>
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

    <!-- Groups Summary -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-collection"></i> Groups Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($groups as $group)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $group->name }}</h6>
                                        <p class="card-text text-muted small">
                                            {{ $group->description ?? 'No description' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary">
                                                {{ $group->users->count() }} member(s)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-dismiss alerts after 3 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
</script>
@endsection
