<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\ActivityLog;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with('users')->orderBy('created_at', 'desc')->get();
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'description' => 'nullable|string',
            'is_private' => 'nullable|boolean',
        ]);
        $validated['is_private'] = $request->has('is_private');
        $group = Group::create($validated);
        
        // Log the activity
        ActivityLog::log(
            "Group '{$group->name}' was created by " . auth()->user()->name,
            'created',
            Group::class,
            $group->id,
            ['name' => $group->name, 'is_private' => $group->is_private]
        );
        
        return redirect()->route('groups.show', $group)->with('success', 'Group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::with('users')->findOrFail($id);
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = Group::with('users')->findOrFail($id);
        $allUsers = \App\Models\User::orderBy('name')->get();
        return view('groups.edit', compact('group', 'allUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'description' => 'nullable|string',
            'is_private' => 'nullable|boolean',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);
        $validated['is_private'] = $request->has('is_private');
        $group->update($validated);

        // Update group members
        $memberIds = $request->input('members', []);
        // Remove group_id from users not in the list
        \App\Models\User::where('group_id', $group->id)
            ->whereNotIn('id', $memberIds)
            ->update(['group_id' => null]);
        // Assign group_id to selected users
        \App\Models\User::whereIn('id', $memberIds)
            ->update(['group_id' => $group->id]);
        
        // Log the activity
        ActivityLog::log(
            "Group '{$group->name}' was updated by " . auth()->user()->name,
            'updated',
            Group::class,
            $group->id,
            ['name' => $group->name, 'members_count' => count($memberIds)]
        );

        return redirect()->route('groups.show', $group)->with('success', 'Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);
        $groupName = $group->name;
        
        $group->delete();
        
        // Log the activity
        ActivityLog::log(
            "Group '{$groupName}' was deleted by " . auth()->user()->name,
            'deleted',
            Group::class,
            $id,
            ['name' => $groupName]
        );
        
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
    /**
     * Add a member to the group.
     */
    public function addMember(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $request->validate([
            'add_member_id' => 'required|exists:users,id',
        ]);
        
        $user = \App\Models\User::findOrFail($request->add_member_id);
        
        // Check if user is already in this group
        if ($user->group_id == $group->id) {
            return redirect()->route('groups.edit', $group)->with('error', 'User is already a member of this group.');
        }
        
        $user->group_id = $group->id;
        $user->save();
        
        // Log the activity
        ActivityLog::log(
            "User '{$user->name}' was added to group '{$group->name}' by " . auth()->user()->name,
            'updated',
            Group::class,
            $group->id,
            ['action' => 'member_added', 'user_id' => $user->id, 'user_name' => $user->name]
        );
        
        return redirect()->route('groups.edit', $group)->with('success', 'Member added successfully.');
    }

    /**
     * Remove a member from the group.
     */
    public function removeMember($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);
        $user = \App\Models\User::findOrFail($userId);
        
        // Check if user is actually in this group
        if ($user->group_id != $group->id) {
            return redirect()->route('groups.edit', $group)->with('error', 'User is not a member of this group.');
        }
        
        $user->group_id = null;
        $user->save();
        
        // Log the activity
        ActivityLog::log(
            "User '{$user->name}' was removed from group '{$group->name}' by " . auth()->user()->name,
            'updated',
            Group::class,
            $group->id,
            ['action' => 'member_removed', 'user_id' => $user->id, 'user_name' => $user->name]
        );
        
        return redirect()->route('groups.edit', $group)->with('success', 'Member removed successfully.');
    }
}
