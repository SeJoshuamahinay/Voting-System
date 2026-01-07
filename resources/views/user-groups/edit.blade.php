@extends('layouts.app')

@section('title', 'Edit User Groups')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">Edit Groups for {{ $user->name }}</h1>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
                <a href="{{ route('user-groups.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-collection"></i> Assign Groups</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user-groups.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Groups:</label>
                            
                            @if($allGroups->count() > 0)
                                <div class="row">
                                    @foreach($allGroups as $group)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="groups[]" 
                                                       value="{{ $group->id }}" 
                                                       id="group{{ $group->id }}"
                                                       {{ $user->groups->contains($group->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="group{{ $group->id }}">
                                                    <strong>{{ $group->name }}</strong>
                                                    @if($group->description)
                                                        <br><small class="text-muted">{{ $group->description }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i> No groups available. 
                                    <a href="{{ route('groups.create') }}">Create a group first</a>.
                                </div>
                            @endif
                        </div>

                        @if($allGroups->count() > 0)
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update Groups
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Current Groups</h5>
                </div>
                <div class="card-body">
                    @if($user->groups->count() > 0)
                        <ul class="list-group">
                            @foreach($user->groups as $group)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $group->name }}</strong>
                                        @if($group->description)
                                            <br><small class="text-muted">{{ $group->description }}</small>
                                        @endif
                                    </div>
                                    <form method="POST" 
                                          action="{{ route('user-groups.detach', [$user->id, $group->id]) }}" 
                                          class="d-inline"
                                          onsubmit="return confirm('Remove from this group?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> User is not assigned to any groups yet.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Add Group -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-plus-circle"></i> Quick Add Group</h6>
                </div>
                <div class="card-body">
                    <form id="quickAddForm">
                        @csrf
                        <div class="mb-2">
                            <select class="form-select" id="quickAddGroup">
                                <option value="">Select a group...</option>
                                @foreach($allGroups->whereNotIn('id', $user->groups->pluck('id')) as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm w-100" onclick="quickAddGroup()">
                            <i class="bi bi-plus"></i> Add Group
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function quickAddGroup() {
    const groupId = document.getElementById('quickAddGroup').value;
    if (!groupId) {
        alert('Please select a group');
        return;
    }

    fetch(`{{ route('user-groups.attach', $user->id) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                           document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ group_id: groupId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>
@endsection
