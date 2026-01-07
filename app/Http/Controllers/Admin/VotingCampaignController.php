<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingCampaign;
use App\Models\Candidate;
use App\Models\ActivityLog;
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
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.voting.create', compact('groups'));
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
        ]);

        $data = $request->all();
        // Handle checkbox: if not present in request, set to false
        $data['allow_multiple_votes'] = $request->has('allow_multiple_votes') ? 1 : 0;

        $campaign = VotingCampaign::create($data);
        
        // Log the activity
        ActivityLog::log(
            "Voting campaign '{$campaign->title}' was created by " . auth()->user()->name,
            'created',
            VotingCampaign::class,
            $campaign->id,
            ['title' => $campaign->title, 'category' => $campaign->category, 'status' => $campaign->status]
        );

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
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('admin.voting.edit', compact('votingCampaign', 'groups'));
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
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $data = $request->all();
        // Handle checkbox: if not present in request, set to false
        $data['allow_multiple_votes'] = $request->has('allow_multiple_votes') ? 1 : 0;

        $votingCampaign->update($data);
        
        // Log the activity
        ActivityLog::log(
            "Voting campaign '{$votingCampaign->title}' was updated by " . auth()->user()->name,
            'updated',
            VotingCampaign::class,
            $votingCampaign->id,
            ['title' => $votingCampaign->title, 'status' => $votingCampaign->status]
        );

        return redirect()->route('voting-campaigns.index')
            ->with('success', 'Voting campaign updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VotingCampaign $votingCampaign)
    {
        $campaignTitle = $votingCampaign->title;
        $campaignId = $votingCampaign->id;
        
        $votingCampaign->delete();
        
        // Log the activity
        ActivityLog::log(
            "Voting campaign '{$campaignTitle}' was deleted by " . auth()->user()->name,
            'deleted',
            VotingCampaign::class,
            $campaignId,
            ['title' => $campaignTitle]
        );
        
        return redirect()->route('voting-campaigns.index')
            ->with('success', 'Voting campaign deleted successfully!');
    }

    /**
     * Manage positions for a campaign.
     */
    public function positions(VotingCampaign $votingCampaign)
    {
        $votingCampaign->load('positions.candidates');
        return view('admin.voting.positions', compact('votingCampaign'));
    }

    /**
     * Store a new position.
     */
    public function storePosition(Request $request, VotingCampaign $votingCampaign)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $position = \App\Models\Position::create([
            'voting_campaign_id' => $votingCampaign->id,
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);
        
        // Log the activity
        ActivityLog::log(
            "Position '{$position->title}' was added to campaign '{$votingCampaign->title}' by " . auth()->user()->name,
            'created',
            \App\Models\Position::class,
            $position->id,
            ['position_title' => $position->title, 'campaign_title' => $votingCampaign->title]
        );

        return redirect()->route('voting-campaigns.positions', $votingCampaign)
            ->with('success', 'Position added successfully!');
    }

    /**
     * Delete a position.
     */
    public function deletePosition(VotingCampaign $votingCampaign, \App\Models\Position $position)
    {
        if ($position->voting_campaign_id !== $votingCampaign->id) {
            return redirect()->back()->with('error', 'Position does not belong to this campaign!');
        }
        
        $positionTitle = $position->title;
        $positionId = $position->id;

        $position->delete();
        
        // Log the activity
        ActivityLog::log(
            "Position '{$positionTitle}' was deleted from campaign '{$votingCampaign->title}' by " . auth()->user()->name,
            'deleted',
            \App\Models\Position::class,
            $positionId,
            ['position_title' => $positionTitle, 'campaign_title' => $votingCampaign->title]
        );
        
        return redirect()->route('voting-campaigns.positions', $votingCampaign)
            ->with('success', 'Position deleted successfully!');
    }

    /**
     * Manage candidates for a campaign.
     */
    public function candidates(VotingCampaign $votingCampaign)
    {
        $votingCampaign->load(['candidates.positionRelation', 'positions']);
        return view('admin.voting.candidates', compact('votingCampaign'));
    }

    /**
     * Store a new candidate.
     */
    public function storeCandidate(Request $request, VotingCampaign $votingCampaign)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'party_list' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        $data['voting_campaign_id'] = $votingCampaign->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate = Candidate::create($data);
        
        // Log the activity
        ActivityLog::log(
            "Candidate '{$candidate->name}' was added to campaign '{$votingCampaign->title}' by " . auth()->user()->name,
            'created',
            Candidate::class,
            $candidate->id,
            ['candidate_name' => $candidate->name, 'campaign_title' => $votingCampaign->title]
        );

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
        
        $candidateName = $candidate->name;
        $candidateId = $candidate->id;

        $candidate->delete();
        
        // Log the activity
        ActivityLog::log(
            "Candidate '{$candidateName}' was deleted from campaign '{$votingCampaign->title}' by " . auth()->user()->name,
            'deleted',
            Candidate::class,
            $candidateId,
            ['candidate_name' => $candidateName, 'campaign_title' => $votingCampaign->title]
        );
        
        return redirect()->route('voting-campaigns.candidates', $votingCampaign)
            ->with('success', 'Candidate deleted successfully!');
    }
}
