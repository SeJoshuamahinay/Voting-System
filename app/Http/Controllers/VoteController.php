<?php

namespace App\Http\Controllers;

use App\Models\VotingCampaign;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VoteController extends Controller
{
    /**
     * Display active voting campaigns.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $user = auth()->user();

        $campaigns = VotingCampaign::active()
            ->with(['candidates.positionRelation', 'group', 'positions.candidates'])
            ->where(function ($query) use ($user) {
                // Show campaigns with no group (public to all)
                $query->whereNull('group_id')
                    // OR campaigns with public groups
                    ->orWhereHas('group', function ($q) {
                        $q->where('is_private', false);
                    });
                
                // If user is logged in, also show private group campaigns they're a member of
                if ($user) {
                    $query->orWhereHas('group', function ($q) use ($user) {
                        $q->where('is_private', true)
                          ->where('id', $user->group_id);
                    });
                }
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE 
                WHEN status = 'active' AND start_date <= NOW() AND end_date >= NOW() THEN 1
                ELSE 2
            END")
            ->orderBy('end_date', 'asc')
            ->get();

        return view('voting', compact('campaigns', 'search'));
    }

    /**
     * Cast a vote.
     */
    public function store(Request $request)
    {
        $campaign = VotingCampaign::findOrFail($request->voting_campaign_id);

        // Validate based on campaign type
        if ($campaign->allow_multiple_votes) {
            $request->validate([
                'voting_campaign_id' => 'required|exists:voting_campaigns,id',
                'candidate_ids' => 'required|array|min:1',
                'candidate_ids.*' => 'exists:candidates,id',
            ], [
                'candidate_ids.required' => 'Please select at least one candidate.',
                'candidate_ids.min' => 'Please select at least one candidate.',
            ]);
        } else {
            // For position-based voting, collect all candidate_id_* fields
            $positionVotes = [];
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'candidate_id_') === 0) {
                    $positionVotes[] = $value;
                }
            }

            if (!empty($positionVotes)) {
                // Position-based voting
                $request->merge(['candidate_ids' => $positionVotes]);
                $request->validate([
                    'voting_campaign_id' => 'required|exists:voting_campaigns,id',
                    'candidate_ids' => 'required|array|min:1',
                    'candidate_ids.*' => 'exists:candidates,id',
                ], [
                    'candidate_ids.required' => 'Please select a candidate for each position.',
                ]);
            } else {
                // Regular single vote
                $request->validate([
                    'voting_campaign_id' => 'required|exists:voting_campaigns,id',
                    'candidate_id' => 'required|exists:candidates,id',
                ]);
            }
        }

        // Check if campaign is active
        if (!$campaign->isActive()) {
            return redirect()->back()->with('error', 'This voting campaign is not active!');
        }

        try {
            DB::beginTransaction();

            if ($campaign->allow_multiple_votes) {
                // Handle multiple votes
                $candidateIds = $request->candidate_ids;
                $votesCreated = 0;

                foreach ($candidateIds as $candidateId) {
                    $candidate = Candidate::findOrFail($candidateId);

                    // Check if candidate belongs to this campaign
                    if ($candidate->voting_campaign_id !== $campaign->id) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Invalid candidate selection!');
                    }

                    // Check if user has already voted for this candidate
                    if ($campaign->hasUserVoted(auth()->id(), $candidate->id)) {
                        continue; // Skip already voted candidates
                    }

                    // Create vote
                    Vote::create([
                        'user_id' => auth()->id(),
                        'voting_campaign_id' => $campaign->id,
                        'candidate_id' => $candidate->id,
                        'voted_at' => now(),
                    ]);

                    // Increment candidate vote count
                    $candidate->incrementVotes();
                    $votesCreated++;
                }

                DB::commit();

                if ($votesCreated > 0) {
                    // Log the voting activity
                    ActivityLog::log(
                        auth()->user()->name . " cast {$votesCreated} vote(s) in campaign: {$campaign->title}",
                        'voted',
                        VotingCampaign::class,
                        $campaign->id,
                        ['votes_count' => $votesCreated, 'candidate_ids' => $candidateIds]
                    );
                    
                    // Store vote details in session for receipt generation
                    session([
                        'vote_receipt_data' => [
                            'campaign_id' => $campaign->id,
                            'candidate_ids' => $candidateIds,
                            'votes_count' => $votesCreated
                        ]
                    ]);
                    
                    return redirect()->route('voting.index')
                        ->with('success', "Successfully cast {$votesCreated} vote(s)!")
                        ->with('download_receipt', true);
                } else {
                    return redirect()->back()->with('error', 'You have already voted for all selected candidates!');
                }
            } else {
                // Handle single vote (could be one or multiple for positions)
                $candidateIds = [];
                
                // Check if it's position-based voting
                if ($request->has('candidate_ids')) {
                    $candidateIds = $request->candidate_ids;
                } else {
                    $candidateIds = [$request->candidate_id];
                }

                // Check if user has already voted in this campaign
                if ($campaign->hasUserVoted(auth()->id())) {
                    return redirect()->back()->with('error', 'You have already voted in this campaign!');
                }

                $votesCreated = 0;
                foreach ($candidateIds as $candidateId) {
                    $candidate = Candidate::findOrFail($candidateId);

                    // Check if candidate belongs to this campaign
                    if ($candidate->voting_campaign_id !== $campaign->id) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Invalid candidate selection!');
                    }

                    // Create vote
                    Vote::create([
                        'user_id' => auth()->id(),
                        'voting_campaign_id' => $campaign->id,
                        'candidate_id' => $candidate->id,
                        'voted_at' => now(),
                    ]);

                    // Increment candidate vote count
                    $candidate->incrementVotes();
                    $votesCreated++;
                }

                DB::commit();

                // Log the voting activity
                ActivityLog::log(
                    auth()->user()->name . " cast {$votesCreated} vote(s) in campaign: {$campaign->title}",
                    'voted',
                    VotingCampaign::class,
                    $campaign->id,
                    ['votes_count' => $votesCreated, 'candidate_ids' => $candidateIds]
                );

                // Store vote details in session for receipt generation
                session([
                    'vote_receipt_data' => [
                        'campaign_id' => $campaign->id,
                        'candidate_ids' => $candidateIds,
                        'votes_count' => $votesCreated
                    ]
                ]);
                
                return redirect()->route('voting.index')
                    ->with('success', $votesCreated === 1 ? 'Your vote has been cast successfully!' : "Successfully cast {$votesCreated} votes!")
                    ->with('download_receipt', true);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to cast vote. Please try again.');
        }
    }

    /**
     * Generate PDF receipt for the vote.
     */
    public function downloadReceipt()
    {
        $receiptData = session('vote_receipt_data');
        
        if (!$receiptData) {
            return redirect()->route('voting.index')->with('error', 'Receipt data not found.');
        }

        $campaign = VotingCampaign::findOrFail($receiptData['campaign_id']);
        $votedCandidates = Candidate::whereIn('id', $receiptData['candidate_ids'])->with('positionRelation')->get();
        
        $user = auth()->user();
        $voteDate = now();
        $receiptNumber = 'VR-' . $campaign->id . '-' . $user->id . '-' . time();

        $data = [
            'campaign' => $campaign,
            'candidates' => $votedCandidates,
            'user' => $user,
            'voteDate' => $voteDate,
            'receiptNumber' => $receiptNumber,
        ];

        // Clear the session data
        session()->forget('vote_receipt_data');

        $pdf = Pdf::loadView('receipts.vote-receipt', $data);
        
        $fileName = 'Vote_Receipt_' . $campaign->id . '_' . time() . '.pdf';
        
        return $pdf->download($fileName);
    }
}
