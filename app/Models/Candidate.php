<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'voting_campaign_id',
        'position_id',
        'name',
        'position',
        'party_list',
        'description',
        'photo',
        'vote_count',
    ];

    /**
     * Get the voting campaign that owns this candidate.
     */
    public function votingCampaign()
    {
        return $this->belongsTo(VotingCampaign::class);
    }

    /**
     * Get the position for this candidate.
     */
    public function positionRelation()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * Get the votes for this candidate.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Increment vote count.
     */
    public function incrementVotes()
    {
        $this->increment('vote_count');
    }

    /**
     * Get vote percentage.
     */
    public function getVotePercentageAttribute()
    {
        $totalVotes = $this->votingCampaign->total_votes;
        if ($totalVotes == 0) return 0;
        return round(($this->vote_count / $totalVotes) * 100, 2);
    }
}
