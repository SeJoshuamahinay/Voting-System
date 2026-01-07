<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_private',
    ];

    /**
     * Get users with single group assignment (legacy).
     */
    public function usersLegacy()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all users in this group (many-to-many).
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group')
                    ->withTimestamps();
    }
}
