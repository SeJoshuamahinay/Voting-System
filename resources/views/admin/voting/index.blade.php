@extends('layouts.admin')

@section('title', 'Voting Campaigns')

@section('page-title', 'Voting Campaigns')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Voting Campaigns</h2>
            <a href="{{ route('voting-campaigns.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Campaign
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Candidates</th>
                                <th>Votes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($campaigns as $campaign)
                                <tr>
                                    <td>
                                        <strong>{{ $campaign->title }}</strong>
                                        @if($campaign->isExpired())
                                            <span class="badge bg-secondary ms-2">Expired</span>
                                        @elseif($campaign->isActive())
                                            <span class="badge bg-success ms-2">Active</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info">{{ ucfirst($campaign->category) }}</span></td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'draft' => 'secondary',
                                                'active' => 'success',
                                                'completed' => 'primary',
                                                'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$campaign->status] ?? 'secondary' }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $campaign->start_date->format('M d, Y H:i') }}</td>
                                    <td>{{ $campaign->end_date->format('M d, Y H:i') }}</td>
                                    <td><span class="badge bg-primary">{{ $campaign->candidates_count }}</span></td>
                                    <td><span class="badge bg-success">{{ $campaign->votes_count }}</span></td>
                                    <td>
                                        <a href="{{ route('voting-campaigns.show', $campaign) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('voting-campaigns.candidates', $campaign) }}" class="btn btn-sm btn-secondary" title="Manage Candidates">
                                            <i class="bi bi-people"></i>
                                        </a>
                                        <a href="{{ route('voting-campaigns.edit', $campaign) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('voting-campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure? This will delete all candidates and votes!')" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No campaigns found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
