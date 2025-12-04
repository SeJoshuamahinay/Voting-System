<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingCampaign;
use App\Models\Candidate;
use Illuminate\Http\Request;

class VotingCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = VotingCampaign::withCount(['candidates', 'votes'])
            ->latest()
            ->paginate(10);
        return view('admin.voting.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.voting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:school,community',
            'status' => 'required|in:draft,active,completed,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'allow_multiple_votes' => 'boolean',
        ]);

        VotingCampaign::create($request->all());

        return redirect()->route('voting-campaigns.index')
            ->with('success', 'Voting campaign created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VotingCampaign $votingCampaign)
    {
        $votingCampaign->load(['candidates.votes', 'votes.user']);
        
        // Calculate analytics
        $analytics = [
            'total_votes' => $votingCampaign->votes()->count(),
            'total_voters' => $votingCampaign->votes()->distinct('user_id')->count('user_id'),
            'candidates_count' => $votingCampaign->candidates()->count(),
        ];

        return view('admin.voting.show', compact('votingCampaign', 'analytics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VotingCampaign $votingCampaign)
    {
        return view('admin.voting.edit', compact('votingCampaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VotingCampaign $votingCampaign)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:school,community',
            'status' => 'required|in:draft,active,completed,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'allow_multiple_votes' => 'boolean',
        ]);

        $votingCampaign->update($request->all());

        return redirect()->route('voting-campaigns.index')
            ->with('success', 'Voting campaign updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VotingCampaign $votingCampaign)
    {
        $votingCampaign->delete();
        return redirect()->route('voting-campaigns.index')
            ->with('success', 'Voting campaign deleted successfully!');
    }

    /**
     * Manage candidates for a campaign.
     */
    public function candidates(VotingCampaign $votingCampaign)
    {
        $votingCampaign->load('candidates');
        return view('admin.voting.candidates', compact('votingCampaign'));
    }

    /**
     * Store a new candidate.
     */
    public function storeCandidate(Request $request, VotingCampaign $votingCampaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'party_list' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        $data['voting_campaign_id'] = $votingCampaign->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($data);

        return redirect()->route('voting-campaigns.candidates', $votingCampaign)
            ->with('success', 'Candidate added successfully!');
    }

    /**
     * Delete a candidate.
     */
    public function deleteCandidate(VotingCampaign $votingCampaign, Candidate $candidate)
    {
        if ($candidate->voting_campaign_id !== $votingCampaign->id) {
            return redirect()->back()->with('error', 'Candidate does not belong to this campaign!');
        }

        $candidate->delete();
        return redirect()->route('voting-campaigns.candidates', $votingCampaign)
            ->with('success', 'Candidate deleted successfully!');
    }
}
