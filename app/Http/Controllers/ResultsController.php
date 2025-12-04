<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VotingCampaign;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function index()
    {
        // Get all campaigns with their candidates and votes
        $campaigns = VotingCampaign::with(['candidates', 'votes'])
            ->withCount(['candidates', 'votes'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get overall statistics
        $totalVotes = Vote::count();
        $totalCampaigns = VotingCampaign::count();
        $activeCampaigns = VotingCampaign::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();

        // Get voter turnout data
        $voterTurnout = DB::table('votes')
            ->select('voting_campaign_id', DB::raw('COUNT(DISTINCT user_id) as voter_count'))
            ->groupBy('voting_campaign_id')
            ->get()
            ->keyBy('voting_campaign_id');

        return view('results', compact('campaigns', 'totalVotes', 'totalCampaigns', 'activeCampaigns', 'voterTurnout'));
    }

    public function show($id)
    {
        $campaign = VotingCampaign::with('candidates')
            ->withCount('votes')
            ->findOrFail($id);

        // Get analytics data
        $analytics = [
            'total_votes' => $campaign->votes_count,
            'total_voters' => Vote::where('voting_campaign_id', $campaign->id)
                ->distinct('user_id')
                ->count('user_id'),
            'candidates_count' => $campaign->candidates->count(),
        ];

        return view('results-detail', compact('campaign', 'analytics'));
    }
}
