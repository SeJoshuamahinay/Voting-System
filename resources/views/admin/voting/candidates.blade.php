@extends('layouts.admin')

@section('title', 'Manage Candidates')

@section('page-title', 'Manage Candidates')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ $votingCampaign->title }}</h4>
                <p class="mb-0 text-muted">{{ $votingCampaign->description }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Candidate</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('voting-campaigns.candidates.store', $votingCampaign) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Candidate Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                    id="position" name="position" placeholder="e.g., President" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="party_list" class="form-label">Party List</label>
                                <input type="text" class="form-control @error('party_list') is-invalid @enderror" 
                                    id="party_list" name="party_list" placeholder="e.g., Costa Party">
                                @error('party_list')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Photo</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                    id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max 2MB</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add Candidate</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Candidates ({{ $votingCampaign->candidates->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @forelse ($votingCampaign->candidates as $candidate)
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex gap-3">
                                                <div>
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                            class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                            style="width: 60px; height: 60px;">
                                                            <i class="bi bi-person fs-3 text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $candidate->name }}</h6>
                                                    <small class="text-muted d-block">{{ $candidate->position }}</small>
                                                    @if($candidate->party_list)
                                                        <small class="text-muted d-block">{{ $candidate->party_list }}</small>
                                                    @endif
                                                    <span class="badge bg-success mt-1">{{ $candidate->vote_count }} votes</span>
                                                </div>
                                                <div>
                                                    <form action="{{ route('voting-campaigns.candidates.delete', [$votingCampaign, $candidate]) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Delete this candidate?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @if($candidate->description)
                                                <p class="mb-0 mt-2 small text-muted">{{ $candidate->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-center text-muted">No candidates added yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('voting-campaigns.index') }}" class="btn btn-secondary">Back to Campaigns</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
