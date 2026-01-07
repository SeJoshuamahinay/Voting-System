<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of users with their groups.
     */
    public function index()
    {
        $users = User::with('groups')->get();
        $groups = Group::all();
        
        return view('user-groups.index', compact('users', 'groups'));
    }

    /**
     * Show the form for editing user groups.
     */
    public function edit(User $user)
    {
        $user->load('groups');
        $allGroups = Group::all();
        
        return view('user-groups.edit', compact('user', 'allGroups'));
    }

    /**
     * Update user's groups.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'groups' => 'array',
            'groups.*' => 'exists:groups,id',
        ]);

        $user->groups()->sync($request->input('groups', []));

        return redirect()->route('user-groups.index')
                        ->with('success', 'User groups updated successfully');
    }

    /**
     * Attach a group to a user.
     */
    public function attach(Request $request, User $user)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        if (!$user->groups()->where('group_id', $request->group_id)->exists()) {
            $user->groups()->attach($request->group_id);
            return response()->json(['message' => 'Group attached successfully']);
        }

        return response()->json(['message' => 'User already in this group'], 422);
    }

    /**
     * Detach a group from a user.
     */
    public function detach(User $user, Group $group)
    {
        $user->groups()->detach($group->id);
        
        return response()->json(['message' => 'Group detached successfully']);
    }

    /**
     * Get user's groups (API endpoint).
     */
    public function getUserGroups(User $user)
    {
        return response()->json([
            'user' => $user,
            'groups' => $user->groups
        ]);
    }

    /**
     * Get all users in a specific group (API endpoint).
     */
    public function getGroupUsers(Group $group)
    {
        return response()->json([
            'group' => $group,
            'users' => $group->users
        ]);
    }
}

