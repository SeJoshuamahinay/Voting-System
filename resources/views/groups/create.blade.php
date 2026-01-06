@extends('layouts.admin')

@section('title', 'Create Group')
@section('page-title', 'Create Group')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Create New Group</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Group Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_private" id="is_private" value="1" {{ old('is_private') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_private">
                                Private Group
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('groups.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
