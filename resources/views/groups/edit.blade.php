@extends('layouts.admin')

@section('title', 'Edit Group')
@section('page-title', 'Edit Group')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Edit Group</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('groups.update', $group) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Group Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $group->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $group->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_private" id="is_private" value="1" {{ old('is_private', $group->is_private) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_private">
                                Private Group
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Members ({{ $group->users->count() }})</label>
                        @if($group->users->count() > 0)
                            <ul class="list-group">
                                @foreach($group->users as $user)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $user->name }} ({{ $user->email }})</span>
                                        <form action="{{ route('groups.removeMember', [$group, $user]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove {{ $user->name }} from this group?')">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No members yet.</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Member</label>
                        <form action="{{ route('groups.addMember', $group) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <select name="add_member_id" id="add_member_id" class="form-select" required>
                                <option value="">Select user...</option>
                                @foreach($allUsers->whereNotIn('id', $group->users->pluck('id')) as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Add Member
                            </button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('groups.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
