<?php

namespace App\Http\Controllers;

use App\Models\VotingCampaign;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Display active voting campaigns.
     */
    public function index()
    {
        $campaigns = VotingCampaign::active()
            ->with('candidates')
            ->get();

        return view('voting', compact('campaigns'));
    }

    /**
     * Cast a vote.
     */
    public function store(Request $request)
    {
        $request->validate([
            'voting_campaign_id' => 'required|exists:voting_campaigns,id',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $campaign = VotingCampaign::findOrFail($request->voting_campaign_id);
        $candidate = Candidate::findOrFail($request->candidate_id);

        // Check if campaign is active
        if (!$campaign->isActive()) {
            return redirect()->back()->with('error', 'This voting campaign is not active!');
        }

        // Check if user has already voted
        if ($campaign->hasUserVoted(auth()->id())) {
            return redirect()->back()->with('error', 'You have already voted in this campaign!');
        }

        // Check if candidate belongs to this campaign
        if ($candidate->voting_campaign_id !== $campaign->id) {
            return redirect()->back()->with('error', 'Invalid candidate selection!');
        }

        try {
            DB::beginTransaction();

            // Create vote
            Vote::create([
                'user_id' => auth()->id(),
                'voting_campaign_id' => $campaign->id,
                'candidate_id' => $candidate->id,
                'voted_at' => now(),
            ]);

            // Increment candidate vote count
            $candidate->incrementVotes();

            DB::commit();

            return redirect()->route('voting.index')
                ->with('success', 'Your vote has been cast successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to cast vote. Please try again.');
        }
    }
}
