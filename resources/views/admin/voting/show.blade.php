@extends('layouts.admin')

@section('title', 'Campaign Results')

@section('page-title', 'Campaign Results')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $votingCampaign->title }}</h3>
                        <p class="mb-0 text-muted">{{ $votingCampaign->description }}</p>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'draft' => 'secondary',
                                'active' => 'success',
                                'completed' => 'primary',
                                'cancelled' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$votingCampaign->status] ?? 'secondary' }} fs-6">
                            {{ ucfirst($votingCampaign->status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Category:</strong> <span class="badge bg-info">{{ ucfirst($votingCampaign->category) }}</span></p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Start Date:</strong> {{ $votingCampaign->start_date->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>End Date:</strong> {{ $votingCampaign->end_date->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Multiple Votes:</strong> {{ $votingCampaign->allow_multiple_votes ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('voting-campaigns.positions', $votingCampaign) }}" class="btn btn-primary">
                    <i class="bi bi-list-task"></i> Manage Positions
                </a>
                <a href="{{ route('voting-campaigns.candidates', $votingCampaign) }}" class="btn btn-success">
                    <i class="bi bi-people"></i> Manage Candidates
                </a>
                <a href="{{ route('voting-campaigns.edit', $votingCampaign) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Campaign
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Votes</h5>
                        <h2>{{ $analytics['total_votes'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Total Voters</h5>
                        <h2>{{ $analytics['total_voters'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5>Total Candidates</h5>
                        <h2>{{ $analytics['candidates_count'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Results by Candidate</h5>
            </div>
            <div class="card-body">
                @if($analytics['total_votes'] > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Candidate</th>
                                    <th>Position</th>
                                    <th>Party List</th>
                                    <th>Votes</th>
                                    <th>Percentage</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($votingCampaign->candidates->sortByDesc('vote_count') as $index => $candidate)
                                    <tr>
                                        <td>
                                            @if($index === 0)
                                                <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($candidate->photo)
                                                    <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                        class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                        style="width: 40px; height: 40px;">
                                                        <i class="bi bi-person text-white"></i>
                                                    </div>
                                                @endif
                                                <strong>{{ $candidate->name }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $candidate->position }}</td>
                                        <td>{{ $candidate->party_list ?? 'N/A' }}</td>
                                        <td><span class="badge bg-success">{{ $candidate->vote_count }}</span></td>
                                        <td>{{ $candidate->vote_percentage }}%</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: {{ $candidate->vote_percentage }}%;" 
                                                    aria-valuenow="{{ $candidate->vote_percentage }}" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ $candidate->vote_percentage }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No votes have been cast yet.</p>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('voting-campaigns.index') }}" class="btn btn-secondary">Back to Campaigns</a>
            <a href="{{ route('voting-campaigns.edit', $votingCampaign) }}" class="btn btn-warning">Edit Campaign</a>
            <a href="{{ route('voting-campaigns.candidates', $votingCampaign) }}" class="btn btn-primary">Manage Candidates</a>
        </div>
    </div>
</div>
@endsection
