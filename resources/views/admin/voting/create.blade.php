@extends('layouts.admin')

@section('title', 'Create Voting Campaign')

@section('page-title', 'Create Voting Campaign')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>Create New Voting Campaign</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('voting-campaigns.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Campaign Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                            id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="school" {{ old('category') == 'school' ? 'selected' : '' }}>School</option>
                                <option value="community" {{ old('category') == 'community' ? 'selected' : '' }}>Community</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date & Time</label>
                            <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date & Time</label>
                            <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="group_id" class="form-label">Group (Optional)</label>
                        <select class="form-select @error('group_id') is-invalid @enderror" 
                            id="group_id" name="group_id">
                            <option value="">-- All Users (Public) --</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }} {{ $group->is_private ? '(Private)' : '(Public)' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">If a private group is selected, only members can see and vote in this campaign</small>
                        @error('group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allow_multiple_votes" 
                                id="allow_multiple_votes" value="1" {{ old('allow_multiple_votes') ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_multiple_votes">
                                Allow Multiple Votes
                                <small class="text-muted d-block">Users can vote for multiple candidates in this campaign</small>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('voting-campaigns.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
