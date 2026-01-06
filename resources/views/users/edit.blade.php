@extends('layouts.admin')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>Edit User: {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" 
                            id="password_confirmation" name="password_confirmation">
                    </div>


                    <div class="mb-3">
                        <label for="group_id" class="form-label">Group</label>
                        <select name="group_id" id="group_id" class="form-select">
                            <option value="">-- No Group --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Roles</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            name="roles[]" value="{{ $role->id }}" 
                                            id="role{{ $role->id }}"
                                            {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role{{ $role->id }}">
                                            {{ $role->name }}
                                            @if($role->description)
                                                <small class="text-muted d-block">{{ $role->description }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
