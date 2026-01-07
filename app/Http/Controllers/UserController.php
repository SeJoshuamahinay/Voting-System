<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles', 'groups'])->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $groups = \App\Models\Group::orderBy('name')->get();
        return view('users.create', compact('roles', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'group_id' => $request->group_id,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        // Sync multiple groups
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        }

        // Log the activity
        ActivityLog::log(
            "User {$user->name} was created by " . auth()->user()->name,
            'created',
            User::class,
            $user->id,
            ['roles' => $request->roles ?? [], 'groups' => $request->groups ?? []]
        );

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['roles.permissions', 'groups']);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $groups = \App\Models\Group::orderBy('name')->get();
        $user->load(['roles', 'groups']);
        return view('users.edit', compact('user', 'roles', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        // Sync multiple groups
        if ($request->has('groups')) {
            $user->groups()->sync($request->groups);
        } else {
            $user->groups()->detach();
        }

        // Log the activity
        ActivityLog::log(
            "User {$user->name} was updated by " . auth()->user()->name,
            'updated',
            User::class,
            $user->id,
            ['roles' => $request->roles ?? [], 'groups' => $request->groups ?? []]
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account!');
        }

        $userName = $user->name;
        $userId = $user->id;
        
        $user->delete();
        
        // Log the activity
        ActivityLog::log(
            "User {$userName} was deleted by " . auth()->user()->name,
            'deleted',
            User::class,
            $userId
        );
        
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
