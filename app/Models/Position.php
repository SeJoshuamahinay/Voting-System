<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'voting_campaign_id',
        'title',
        'description',
        'order',
    ];

    /**
     * Get the voting campaign for this position.
     */
    public function votingCampaign()
    {
        return $this->belongsTo(VotingCampaign::class);
    }

    /**
     * Get the candidates for this position.
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
