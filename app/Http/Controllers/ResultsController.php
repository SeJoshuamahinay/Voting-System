<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VotingCampaign;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Get all campaigns with their candidates, positions, and votes
        $campaigns = VotingCampaign::with(['candidates.positionRelation', 'positions.candidates', 'votes'])
            ->withCount(['candidates', 'votes'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE 
                WHEN status = 'active' AND start_date <= NOW() AND end_date >= NOW() THEN 1
                WHEN status = 'active' THEN 2
                WHEN status = 'completed' THEN 3
                WHEN status = 'draft' THEN 4
                ELSE 5
            END")
            ->orderBy('end_date', 'desc')
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

        return view('results', compact('campaigns', 'totalVotes', 'totalCampaigns', 'activeCampaigns', 'voterTurnout', 'search'));
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
