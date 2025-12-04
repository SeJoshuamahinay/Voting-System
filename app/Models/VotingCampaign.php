<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VotingCampaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'start_date',
        'end_date',
        'allow_multiple_votes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'allow_multiple_votes' => 'boolean',
    ];

    /**
     * Get the candidates for this campaign.
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get the votes for this campaign.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Check if the campaign is active.
     */
    public function isActive()
    {
        $now = Carbon::now();
        return $this->status === 'active' 
            && $now->greaterThanOrEqualTo($this->start_date)
            && $now->lessThanOrEqualTo($this->end_date);
    }

    /**
     * Check if the campaign has expired.
     */
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->end_date);
    }

    /**
     * Check if user has voted in this campaign.
     */
    public function hasUserVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    /**
     * Get total votes count.
     */
    public function getTotalVotesAttribute()
    {
        return $this->votes()->count();
    }

    /**
     * Scope for active campaigns only.
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('status', 'active')
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }
}
