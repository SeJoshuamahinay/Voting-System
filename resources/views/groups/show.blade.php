@extends('layouts.admin')

@section('title', 'Group Details')
@section('page-title', 'Group Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $group->name }}</h3>
                <a href="{{ route('groups.edit', $group) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $group->description ?: 'No description' }}</p>
                <p><strong>Status:</strong>
                    @if($group->is_private)
                        <span class="badge bg-danger">Private</span>
                    @else
                        <span class="badge bg-success">Public</span>
                    @endif
                </p>
                <p><strong>Created:</strong> {{ $group->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Last Updated:</strong> {{ $group->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Members ({{ $group->users->count() }})</h5>
            </div>
            <div class="card-body">
                @if($group->users->count())
                    <ul class="list-group">
                        @foreach($group->users as $user)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $user->name }}
                                <span class="badge bg-primary">{{ $user->email }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No members in this group.</p>
                @endif
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('groups.index') }}" class="btn btn-secondary">Back to Groups</a>
        </div>
    </div>
</div>
@endsection
