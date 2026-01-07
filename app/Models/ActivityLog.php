<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'log_name',
        'description',
        'user_id',
        'user_name',
        'event',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user who performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject model.
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the badge color based on event type.
     */
    public function getEventBadgeAttribute()
    {
        return match($this->event) {
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            'login' => 'primary',
            'logout' => 'secondary',
            'voted' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Get the icon based on event type.
     */
    public function getEventIconAttribute()
    {
        return match($this->event) {
            'created' => 'bi-plus-circle',
            'updated' => 'bi-pencil-square',
            'deleted' => 'bi-trash',
            'login' => 'bi-box-arrow-in-right',
            'logout' => 'bi-box-arrow-right',
            'voted' => 'bi-check2-square',
            'registered' => 'bi-person-plus',
            default => 'bi-activity'
        };
    }

    /**
     * Static method to log activity.
     */
    public static function log($description, $event, $subjectType = null, $subjectId = null, $properties = [])
    {
        $user = auth()->user();
        
        return self::create([
            'log_name' => 'default',
            'description' => $description,
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'event' => $event,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
