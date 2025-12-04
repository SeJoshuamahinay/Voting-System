<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'voting_campaign_id',
        'candidate_id',
        'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    /**
     * Get the user that cast the vote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the voting campaign.
     */
    public function votingCampaign()
    {
        return $this->belongsTo(VotingCampaign::class);
    }

    /**
     * Get the candidate that received the vote.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
