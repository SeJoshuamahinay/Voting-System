<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .hero-bg {
            background: linear-gradient(to bottom, #fff7d1, #ffeaa7);
            padding: 80px 0;
        }

        .candidate-card {
            border: 1px solid #cfcfcf;
            border-radius: 12px;D
            padding: 20px;
            transition: 0.2s ease;
            height: 100%;
        }

        .candidate-card:hover {
            border-color: #6f42c1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.06);
        }

        .candidate-img {
            width: 80px;
            height: 80px;
            background: #d7d7d7;
            border-radius: 50%;
            object-fit: cover;
        }

        .toggle-btn {
            border-radius: 20px;
            padding: 6px 25px;
        }

        .toggle-btn.active {
            background: #f8d54b;
            font-weight: 600;
        }

        .campaign-box {
            background: #f8f9fa;
            border-left: 4px solid #6f42c1;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .campaign-box.expired {
            border-left-color: #6c757d;
            opacity: 0.6;
        }
    </style>
</head>

<body>

<!-- NAV INCLUDE -->
@include('nav')

<!-- HERO SECTION -->
<section class="hero-bg">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Your Vote Matters!</h2>
                <p class="mb-4">Make your voice count. Select your candidate and submit your vote securely.</p>
                @auth
                    <a href="#voting-section" class="btn btn-primary px-4">Vote Now</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary px-4">Login to Vote</a>
                @endauth
            </div>

            <div class="col-lg-6 text-center">
                <i class="bi bi-ballot-heart" style="font-size: 200px; color: #6f42c1;"></i>
            </div>

        </div>
    </div>
</section>

<!-- CATEGORY TOGGLE -->
<section class="py-4" id="voting-section">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-8">
                <form action="{{ route('voting.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" 
                        placeholder="Search campaigns by title, description, or category..." 
                        value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                    @if($search ?? false)
                        <a href="{{ route('voting.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn toggle-btn category-filter active" data-category="all">All</button>
                <button class="btn toggle-btn category-filter" data-category="school">School</button>
                <button class="btn toggle-btn category-filter" data-category="community">Community</button>
            </div>
        </div>
    </div>
</section>

<!-- ELECTIONS IN PROGRESS -->
<section class="pb-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('download_receipt'))
            <script>
                // Auto-download receipt and show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Vote Submitted Successfully!',
                    html: 'Your vote has been recorded. Your receipt is downloading now...<br><br><small>If download doesn\'t start, <a href="{{ route("vote.receipt") }}" class="text-primary"><strong>click here</strong></a></small>',
                    confirmButtonColor: '#6f42c1',
                    confirmButtonText: 'OK',
                    timer: 5000,
                    didOpen: () => {
                        // Trigger automatic download
                        window.location.href = '{{ route("vote.receipt") }}';
                    }
                });
            </script>
        @endif

        @forelse($campaigns as $campaign)
            <div class="campaign-box {{ $campaign->isExpired() ? 'expired' : '' }}" data-category="{{ $campaign->category }}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">
                            {{ $campaign->title }}
                            @if($campaign->group)
                                @if($campaign->group->is_private)
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-lock-fill"></i> {{ $campaign->group->name }}
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="bi bi-people-fill"></i> {{ $campaign->group->name }}
                                    </span>
                                @endif
                            @endif
                        </h4>
                        <p class="mb-2 text-muted">{{ $campaign->description }}</p>
                        <div>
                            <span class="badge bg-info">{{ ucfirst($campaign->category) }}</span>
                            @if($campaign->isExpired())
                                <span class="badge bg-secondary">Expired</span>
                            @elseif($campaign->isActive())
                                <span class="badge bg-success">Active</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Ends: {{ $campaign->end_date->format('M d, Y H:i') }}</small>
                        @auth
                            @if($campaign->allow_multiple_votes)
                                @php
                                    $userVoteCount = $campaign->votes()->where('user_id', auth()->id())->count();
                                @endphp
                                @if($userVoteCount > 0)
                                    <span class="badge bg-info mt-2">
                                        <i class="bi bi-check-circle"></i> {{ $userVoteCount }} Vote(s) Cast
                                    </span>
                                @endif
                            @else
                                @if($campaign->hasUserVoted(auth()->id()))
                                    <span class="badge bg-success mt-2"><i class="bi bi-check-circle"></i> You Voted</span>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                @if($campaign->isExpired())
                    <div class="alert alert-secondary mb-0">
                        <i class="bi bi-clock-history"></i> This voting campaign has ended.
                    </div>
                @elseif(!auth()->check())
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-info-circle"></i> Please <a href="{{ route('login') }}">login</a> to vote.
                    </div>
                @elseif(!$campaign->allow_multiple_votes && $campaign->hasUserVoted(auth()->id()))
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle"></i> You have already voted in this campaign. Thank you!
                    </div>
                @elseif($campaign->allow_multiple_votes)
                    @php
                        // Check if user has voted for all candidates
                        $totalCandidates = $campaign->candidates->count();
                        $votedCandidatesCount = $campaign->votes()->where('user_id', auth()->id())->count();
                        $hasVotedForAll = $totalCandidates > 0 && $votedCandidatesCount >= $totalCandidates;
                        
                        // Check if there are any candidates left to vote for
                        $availableCandidates = $campaign->candidates->filter(function($candidate) use ($campaign) {
                            return !$campaign->hasUserVoted(auth()->id(), $candidate->id);
                        });
                    @endphp
                    
                    @if($hasVotedForAll || $availableCandidates->count() === 0)
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle-fill"></i> <strong>Voting Complete!</strong> You have voted for all available candidates in this campaign. Thank you for participating!
                        </div>
                    @else
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle"></i> <strong>Multiple votes allowed:</strong> You can vote for multiple candidates in this campaign.
                            @if($votedCandidatesCount > 0)
                                <br><small>You have cast {{ $votedCandidatesCount }} vote(s) so far. {{ $availableCandidates->count() }} candidate(s) remaining.</small>
                            @endif
                        </div>
                        <form action="{{ route('vote.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="voting_campaign_id" value="{{ $campaign->id }}">

                            @if($campaign->positions->count() > 0)
                            @foreach($campaign->positions as $position)
                                <div class="mb-4">
                                    <h5 class="fw-bold border-bottom pb-2">{{ $position->title }}</h5>
                                    @if($position->description)
                                        <p class="text-muted small mb-3">{{ $position->description }}</p>
                                    @endif
                                    
                                    <div class="row g-3">
                                        @foreach($position->candidates as $candidate)
                                            @php
                                                $hasVotedForCandidate = $campaign->allow_multiple_votes && 
                                                    $campaign->hasUserVoted(auth()->id(), $candidate->id);
                                            @endphp
                                            <div class="col-md-6 col-lg-4">
                                                <label class="w-100">
                                                    <div class="candidate-card d-flex gap-3 align-items-center {{ $hasVotedForCandidate ? 'border-success' : '' }}">
                                                        <div class="d-flex gap-3 align-items-center flex-grow-1">
                                                            @if($candidate->photo)
                                                                <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                                    class="candidate-img" alt="{{ $candidate->name }}">
                                                            @else
                                                                <div class="candidate-img d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-person fs-2"></i>
                                                                </div>
                                                            @endif

                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold m-0">
                                                                    {{ $candidate->name }}
                                                                    @if($hasVotedForCandidate)
                                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                                    @endif
                                                                </h6>
                                                                @if($candidate->party_list)
                                                                    <small class="text-muted d-block">{{ $candidate->party_list }}</small>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div>
                                                            @if($campaign->allow_multiple_votes)
                                                                <input type="checkbox" name="candidate_ids[]" 
                                                                    value="{{ $candidate->id }}" 
                                                                    {{ $hasVotedForCandidate ? 'disabled checked' : '' }}>
                                                            @else
                                                                <input type="radio" name="candidate_id_{{ $position->id }}" 
                                                                    value="{{ $candidate->id }}" 
                                                                    required>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Fallback for campaigns without positions --}}
                            <div class="row g-3">
                                @foreach($campaign->candidates as $candidate)
                                    @php
                                        $hasVotedForCandidate = $campaign->allow_multiple_votes && 
                                            $campaign->hasUserVoted(auth()->id(), $candidate->id);
                                    @endphp
                                    <div class="col-md-6 col-lg-4">
                                        <label class="w-100">
                                            <div class="candidate-card d-flex gap-3 align-items-center {{ $hasVotedForCandidate ? 'border-success' : '' }}">
                                                <div class="d-flex gap-3 align-items-center flex-grow-1">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                            class="candidate-img" alt="{{ $candidate->name }}">
                                                    @else
                                                        <div class="candidate-img d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-person fs-2"></i>
                                                        </div>
                                                    @endif

                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold m-0">
                                                            {{ $candidate->name }}
                                                            @if($hasVotedForCandidate)
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted d-block">{{ $candidate->position }}</small>
                                                        @if($candidate->party_list)
                                                            <small class="text-muted d-block">{{ $candidate->party_list }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div>
                                                    @if($campaign->allow_multiple_votes)
                                                        <input type="checkbox" name="candidate_ids[]" 
                                                            value="{{ $candidate->id }}" 
                                                            {{ $hasVotedForCandidate ? 'disabled checked' : '' }}>
                                                    @else
                                                        <input type="radio" name="candidate_id" 
                                                            value="{{ $candidate->id }}" 
                                                            required>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($campaign->candidates->count() > 0)
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle"></i> Submit Vote
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info mb-0 mt-3">
                                No candidates available for this campaign yet.
                            </div>
                        @endif
                    </form>
                    @endif
                @else
                    {{-- Single vote campaign with no vote yet --}}
                    <form action="{{ route('vote.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="voting_campaign_id" value="{{ $campaign->id }}">

                        @if($campaign->positions->count() > 0)
                            @foreach($campaign->positions as $position)
                                <div class="mb-4">
                                    <h5 class="fw-bold border-bottom pb-2">{{ $position->title }}</h5>
                                    @if($position->description)
                                        <p class="text-muted small mb-3">{{ $position->description }}</p>
                                    @endif
                                    
                                    <div class="row g-3">
                                        @foreach($position->candidates as $candidate)
                                            <div class="col-md-6 col-lg-4">
                                                <label class="w-100">
                                                    <div class="candidate-card d-flex gap-3 align-items-center">
                                                        <div class="d-flex gap-3 align-items-center flex-grow-1">
                                                            @if($candidate->photo)
                                                                <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                                    class="candidate-img" alt="{{ $candidate->name }}">
                                                            @else
                                                                <div class="candidate-img d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-person fs-2"></i>
                                                                </div>
                                                            @endif

                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold m-0">{{ $candidate->name }}</h6>
                                                                @if($candidate->party_list)
                                                                    <small class="text-muted d-block">{{ $candidate->party_list }}</small>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <input type="radio" name="candidate_id_{{ $position->id }}" 
                                                                value="{{ $candidate->id }}" 
                                                                required>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Fallback for campaigns without positions --}}
                            <div class="row g-3">
                                @foreach($campaign->candidates as $candidate)
                                    <div class="col-md-6 col-lg-4">
                                        <label class="w-100">
                                            <div class="candidate-card d-flex gap-3 align-items-center">
                                                <div class="d-flex gap-3 align-items-center flex-grow-1">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                            class="candidate-img" alt="{{ $candidate->name }}">
                                                    @else
                                                        <div class="candidate-img d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-person fs-2"></i>
                                                        </div>
                                                    @endif

                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold m-0">{{ $candidate->name }}</h6>
                                                        <small class="text-muted d-block">{{ $candidate->position }}</small>
                                                        @if($candidate->party_list)
                                                            <small class="text-muted d-block">{{ $candidate->party_list }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div>
                                                    <input type="radio" name="candidate_id" 
                                                        value="{{ $candidate->id }}" 
                                                        required>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($campaign->candidates->count() > 0)
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle"></i> Submit Vote
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info mb-0 mt-3">
                                No candidates available for this campaign yet.
                            </div>
                        @endif
                    </form>
                @endif
            </div>
        @empty
            <div class="p-5 border rounded-3 bg-white text-center">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-3">No Active Voting Campaigns</h5>
                <p class="text-muted">There are currently no voting campaigns available. Check back later!</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Category filter functionality
    document.querySelectorAll('.category-filter').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.category-filter').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            // Show/hide campaigns
            document.querySelectorAll('.campaign-box').forEach(box => {
                if (category === 'all' || box.dataset.category === category) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            });
        });
    });

    // Vote confirmation with SweetAlert2
    document.addEventListener('DOMContentLoaded', function() {
        const voteForms = document.querySelectorAll('form[action="{{ route('vote.store') }}"]');
        
        voteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Check if at least one candidate is selected
                const radioInputs = form.querySelectorAll('input[type="radio"]:checked');
                const checkboxInputs = form.querySelectorAll('input[type="checkbox"]:checked:not([disabled])');
                
                if (radioInputs.length === 0 && checkboxInputs.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'Please select at least one candidate before submitting your vote.',
                        confirmButtonColor: '#6f42c1'
                    });
                    return;
                }
                
                // Get campaign title from the form's parent campaign box
                const campaignBox = form.closest('.campaign-box');
                const campaignTitle = campaignBox.querySelector('h4').textContent.trim();
                
                // Collect selected candidates details
                const selectedCandidates = [];
                
                // Process radio inputs
                radioInputs.forEach(input => {
                    const candidateCard = input.closest('.candidate-card');
                    const candidateName = candidateCard.querySelector('h6').textContent.trim();
                    const positionLabel = candidateCard.closest('.mb-4').querySelector('h5');
                    const positionName = positionLabel ? positionLabel.textContent.trim() : 'Main Candidate';
                    
                    selectedCandidates.push({
                        name: candidateName,
                        position: positionName
                    });
                });
                
                // Process checkbox inputs
                checkboxInputs.forEach(input => {
                    const candidateCard = input.closest('.candidate-card');
                    const candidateName = candidateCard.querySelector('h6').textContent.trim();
                    const positionLabel = candidateCard.closest('.mb-4')?.querySelector('h5');
                    const positionName = positionLabel ? positionLabel.textContent.trim() : 'Candidate';
                    
                    selectedCandidates.push({
                        name: candidateName,
                        position: positionName
                    });
                });
                
                // Build HTML list of selected candidates
                let candidatesListHTML = '<div class="text-start mt-3 mb-3" style="max-height: 300px; overflow-y: auto;">';
                candidatesListHTML += '<strong>Your Selected Votes:</strong><ul class="mt-2">';
                selectedCandidates.forEach(candidate => {
                    candidatesListHTML += `<li><strong>${candidate.name}</strong> - <em>${candidate.position}</em></li>`;
                });
                candidatesListHTML += '</ul></div>';
                
                const selectedCount = radioInputs.length + checkboxInputs.length;
                const candidateText = selectedCount === 1 ? 'candidate' : 'candidates';
                
                Swal.fire({
                    title: 'Confirm Your Vote',
                    html: `You are about to submit your vote for <strong>${selectedCount} ${candidateText}</strong> in "<strong>${campaignTitle}</strong>".${candidatesListHTML}<small class="text-danger"><i class="bi bi-exclamation-triangle"></i> This action cannot be undone.</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#6f42c1',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-check-circle"></i> Yes, Submit My Vote',
                    cancelButtonText: '<i class="bi bi-x-circle"></i> Cancel',
                    reverseButtons: true,
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Submitting Your Vote...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit the form
                        form.submit();
                    }
                });
            });
        });
    });
</script>

</body>
</html>
