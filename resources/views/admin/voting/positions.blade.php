@extends('layouts.admin')

@section('title', 'Manage Positions')

@section('page-title', 'Manage Positions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>{{ $votingCampaign->title }} - Positions</h3>
                <p class="text-muted">Create positions for this campaign before adding candidates</p>
            </div>
            <div>
                <a href="{{ route('voting-campaigns.show', $votingCampaign) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Campaign
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Add Position Form -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Position</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('voting-campaigns.positions.store', $votingCampaign) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Position Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                    id="title" name="title" value="{{ old('title') }}" 
                                    placeholder="e.g., President, Vice President" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3" 
                                    placeholder="Brief description of the position">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                    id="order" name="order" value="{{ old('order', 0) }}" 
                                    placeholder="0">
                                <small class="text-muted">Lower numbers appear first</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Add Position
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Positions List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Positions ({{ $votingCampaign->positions->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if($votingCampaign->positions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Position Title</th>
                                            <th>Description</th>
                                            <th>Candidates</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($votingCampaign->positions as $position)
                                            <tr>
                                                <td><span class="badge bg-secondary">{{ $position->order }}</span></td>
                                                <td><strong>{{ $position->title }}</strong></td>
                                                <td>{{ $position->description ?: 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $position->candidates->count() }}</span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('voting-campaigns.positions.delete', [$votingCampaign, $position]) }}" 
                                                        method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Delete this position? All associated candidates will also be deleted!')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle"></i> No positions added yet. Add positions before adding candidates.
                            </div>
                        @endif
                    </div>
                    @if($votingCampaign->positions->count() > 0)
                        <div class="card-footer">
                            <a href="{{ route('voting-campaigns.candidates', $votingCampaign) }}" class="btn btn-success">
                                <i class="bi bi-people"></i> Manage Candidates
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
