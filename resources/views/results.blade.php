<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Vote2Voice - Election Results</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
        }
        .stats-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
        }
        .stats-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
        }
        .campaign-card {
            transition: transform 0.2s;
        }
        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

{{-- NAVIGATION --}}
@include('nav')

<div class="container py-5">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">Election Results Dashboard</h2>
            <p class="text-muted">Track real-time voting results and analytics across all campaigns</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('voting.index') }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Cast Your Vote
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('results') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" 
                    placeholder="Search campaigns by title, description, or category..." 
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
                @if($search)
                    <a href="{{ route('results') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="row mb-4">
        <div class="col-12 col-md-6 mb-3">
            <div class="stats-card-2 w-100">
                <h6 class="mb-2">Active Campaigns</h6>
                <h2 class="mb-0">{{ $activeCampaigns }}</h2>
                <small><i class="bi bi-lightning-fill"></i> Currently in progress</small>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <div class="stats-card-3 w-100">
                <h6 class="mb-2">Total Campaigns</h6>
                <h2 class="mb-0">{{ $totalCampaigns }}</h2>
                <small><i class="bi bi-calendar-check"></i> All time</small>
            </div>
        </div>
    </div>

    <!-- Campaigns with Charts -->
    @forelse($campaigns as $campaign)
        <div class="card shadow-sm mb-4 campaign-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $campaign->title }}</h4>
                        <p class="text-muted mb-2">{{ $campaign->description }}</p>
                        <div>
                            <span class="badge bg-info">{{ ucfirst($campaign->category) }}</span>
                            @if($campaign->isActive() && !$campaign->isExpired())
                                <span class="badge bg-success">
                                    <i class="bi bi-circle-fill" style="font-size: 8px;"></i> Active
                                </span>
                            @elseif($campaign->isExpired())
                                <span class="badge bg-secondary">
                                    <i class="bi bi-clock-history"></i> Ended
                                </span>
                            @elseif($campaign->status === 'draft')
                                <span class="badge bg-warning">
                                    <i class="bi bi-pencil"></i> Draft
                                </span>
                            @else
                                <span class="badge bg-primary">{{ ucfirst($campaign->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Ends: {{ $campaign->end_date->format('M d, Y H:i') }}</small>
                        <small class="text-muted d-block mt-1">
                            Total Votes: <strong>{{ $campaign->votes_count }}</strong>
                        </small>
                    </div>
                </div>

                @if($campaign->candidates->count() > 0 && $campaign->votes_count > 0)
                    @if($campaign->positions->count() > 0)
                        {{-- Display results grouped by positions --}}
                        @foreach($campaign->positions as $position)
                            @php
                                $positionCandidates = $position->candidates;
                            @endphp
                            @if($positionCandidates->count() > 0)
                                <div class="mb-4">
                                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                                        <i class="bi bi-award"></i> {{ $position->title }}
                                    </h5>
                                    @if($position->description)
                                        <p class="text-muted small mb-3">{{ $position->description }}</p>
                                    @endif

                                    <div class="row">
                                        <!-- Bar Chart -->
                                        <div class="col-lg-7 mb-3">
                                            <div class="p-3 bg-light rounded" style="height: 350px;">
                                                <h6 class="fw-bold mb-3">Vote Tally - Bar Chart</h6>
                                                <div style="height: 280px;">
                                                    <canvas id="barChart{{ $campaign->id }}_{{ $position->id }}"></canvas>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pie Chart -->
                                        <div class="col-lg-5 mb-3">
                                            <div class="p-3 bg-light rounded" style="height: 350px;">
                                                <h6 class="fw-bold mb-3">Vote Distribution - Pie Chart</h6>
                                                <div style="height: 280px;">
                                                    <canvas id="pieChart{{ $campaign->id }}_{{ $position->id }}"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detailed Results Table -->
                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Candidate</th>
                                                    <th>Party</th>
                                                    <th>Votes</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($positionCandidates->sortByDesc('vote_count') as $index => $candidate)
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
                                                                        class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                                                @else
                                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                                        style="width: 35px; height: 35px;">
                                                                        <i class="bi bi-person text-white"></i>
                                                                    </div>
                                                                @endif
                                                                <strong>{{ $candidate->name }}</strong>
                                                            </div>
                                                        </td>
                                                        <td>{{ $candidate->party_list ?? 'Independent' }}</td>
                                                        <td><span class="badge bg-primary">{{ $candidate->vote_count }}</span></td>
                                                        <td>
                                                            @php
                                                                $totalPositionVotes = $positionCandidates->sum('vote_count');
                                                                $percentage = $totalPositionVotes > 0 ? round(($candidate->vote_count / $totalPositionVotes) * 100, 1) : 0;
                                                            @endphp
                                                            <div class="progress" style="height: 20px; width: 100px;">
                                                                <div class="progress-bar" style="width: {{ $percentage }}%">
                                                                    {{ $percentage }}%
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Bar Chart
                                            const barCtx{{ $campaign->id }}_{{ $position->id }} = document.getElementById('barChart{{ $campaign->id }}_{{ $position->id }}').getContext('2d');
                                            new Chart(barCtx{{ $campaign->id }}_{{ $position->id }}, {
                                                type: 'bar',
                                                data: {
                                                    labels: {!! json_encode($positionCandidates->pluck('name')->toArray()) !!},
                                                    datasets: [{
                                                        label: 'Votes',
                                                        data: {!! json_encode($positionCandidates->pluck('vote_count')->toArray()) !!},
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.8)',
                                                            'rgba(54, 162, 235, 0.8)',
                                                            'rgba(255, 206, 86, 0.8)',
                                                            'rgba(75, 192, 192, 0.8)',
                                                            'rgba(153, 102, 255, 0.8)',
                                                            'rgba(255, 159, 64, 0.8)'
                                                        ],
                                                        borderColor: [
                                                            'rgba(255, 99, 132, 1)',
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 206, 86, 1)',
                                                            'rgba(75, 192, 192, 1)',
                                                            'rgba(153, 102, 255, 1)',
                                                            'rgba(255, 159, 64, 1)'
                                                        ],
                                                        borderWidth: 2
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: false
                                                        },
                                                        title: {
                                                            display: false
                                                        }
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                stepSize: 1
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Pie Chart
                                            const pieCtx{{ $campaign->id }}_{{ $position->id }} = document.getElementById('pieChart{{ $campaign->id }}_{{ $position->id }}').getContext('2d');
                                            new Chart(pieCtx{{ $campaign->id }}_{{ $position->id }}, {
                                                type: 'pie',
                                                data: {
                                                    labels: {!! json_encode($positionCandidates->pluck('name')->toArray()) !!},
                                                    datasets: [{
                                                        label: 'Vote Distribution',
                                                        data: {!! json_encode($positionCandidates->pluck('vote_count')->toArray()) !!},
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 0.8)',
                                                            'rgba(54, 162, 235, 0.8)',
                                                            'rgba(255, 206, 86, 0.8)',
                                                            'rgba(75, 192, 192, 0.8)',
                                                            'rgba(153, 102, 255, 0.8)',
                                                            'rgba(255, 159, 64, 0.8)'
                                                        ],
                                                        borderColor: '#fff',
                                                        borderWidth: 2
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            position: 'bottom'
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    let label = context.label || '';
                                                                    let value = context.parsed || 0;
                                                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                                    let percentage = ((value / total) * 100).toFixed(1);
                                                                    return label + ': ' + value + ' votes (' + percentage + '%)';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Fallback for campaigns without positions --}}
                        <div class="row">
                            <!-- Bar Chart -->
                            <div class="col-lg-7 mb-3">
                                <div class="p-3 bg-light rounded" style="height: 350px;">
                                    <h6 class="fw-bold mb-3">Vote Tally - Bar Chart</h6>
                                    <div style="height: 280px;">
                                        <canvas id="barChart{{ $campaign->id }}"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-lg-5 mb-3">
                                <div class="p-3 bg-light rounded" style="height: 350px;">
                                    <h6 class="fw-bold mb-3">Voter Turnout - Pie Chart</h6>
                                    <div style="height: 280px;">
                                        <canvas id="pieChart{{ $campaign->id }}"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Results Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Candidate</th>
                                        <th>Position</th>
                                        <th>Party</th>
                                        <th>Votes</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaign->candidates->sortByDesc('vote_count') as $index => $candidate)
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
                                                            class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                            style="width: 35px; height: 35px;">
                                                            <i class="bi bi-person text-white"></i>
                                                        </div>
                                                    @endif
                                                    <strong>{{ $candidate->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $candidate->position }}</td>
                                            <td>{{ $candidate->party_list ?? 'Independent' }}</td>
                                            <td><span class="badge bg-primary">{{ $candidate->vote_count }}</span></td>
                                            <td>
                                                <div class="progress" style="height: 20px; width: 100px;">
                                                    <div class="progress-bar" style="width: {{ $candidate->vote_percentage }}%">
                                                        {{ $candidate->vote_percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Bar Chart
                                const barCtx{{ $campaign->id }} = document.getElementById('barChart{{ $campaign->id }}').getContext('2d');
                                new Chart(barCtx{{ $campaign->id }}, {
                                    type: 'bar',
                                    data: {
                                        labels: {!! json_encode($campaign->candidates->pluck('name')->toArray()) !!},
                                        datasets: [{
                                            label: 'Votes',
                                            data: {!! json_encode($campaign->candidates->pluck('vote_count')->toArray()) !!},
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(255, 206, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)',
                                                'rgba(153, 102, 255, 0.8)',
                                                'rgba(255, 159, 64, 0.8)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            title: {
                                                display: false
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1
                                                }
                                            }
                                        }
                                    }
                                });

                                // Pie Chart
                                const pieCtx{{ $campaign->id }} = document.getElementById('pieChart{{ $campaign->id }}').getContext('2d');
                                new Chart(pieCtx{{ $campaign->id }}, {
                                    type: 'pie',
                                    data: {
                                        labels: {!! json_encode($campaign->candidates->pluck('name')->toArray()) !!},
                                        datasets: [{
                                            label: 'Vote Distribution',
                                            data: {!! json_encode($campaign->candidates->pluck('vote_count')->toArray()) !!},
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(255, 206, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)',
                                                'rgba(153, 102, 255, 0.8)',
                                                'rgba(255, 159, 64, 0.8)'
                                            ],
                                            borderColor: '#fff',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'bottom'
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        let label = context.label || '';
                                                        let value = context.parsed || 0;
                                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                        let percentage = ((value / total) * 100).toFixed(1);
                                                        return label + ': ' + value + ' votes (' + percentage + '%)';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    @endif
                @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> 
                        @if($campaign->candidates->count() === 0)
                            No candidates have been added to this campaign yet.
                        @else
                            No votes have been cast yet.
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-3">No Campaigns Available</h5>
                <p class="text-muted">There are no voting campaigns to display results for.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
