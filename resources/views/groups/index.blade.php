@extends('layouts.admin')

@section('title', 'Groups')
@section('page-title', 'Groups')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Groups</h2>
    <a href="{{ route('groups.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Create Group
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Private?</th>
                        <th>Members</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $group)
                        <tr>
                            <td><strong>{{ $group->name }}</strong></td>
                            <td>{{ $group->description }}</td>
                            <td>
                                @if($group->is_private)
                                    <span class="badge bg-danger">Private</span>
                                @else
                                    <span class="badge bg-success">Public</span>
                                @endif
                            </td>
                            <td>{{ $group->users->count() }}</td>
                            <td>
                                <a href="{{ route('groups.show', $group) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('groups.edit', $group) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('groups.destroy', $group) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this group?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
