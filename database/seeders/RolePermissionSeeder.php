<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Can create, edit, and delete users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Can create, edit, and delete roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'description' => 'Can create, edit, and delete permissions'],
            ['name' => 'Create Votes', 'slug' => 'create-votes', 'description' => 'Can create voting sessions'],
            ['name' => 'Edit Votes', 'slug' => 'edit-votes', 'description' => 'Can edit voting sessions'],
            ['name' => 'Delete Votes', 'slug' => 'delete-votes', 'description' => 'Can delete voting sessions'],
            ['name' => 'View Results', 'slug' => 'view-results', 'description' => 'Can view voting results'],
            ['name' => 'Cast Vote', 'slug' => 'cast-vote', 'description' => 'Can cast votes'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create Roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Full system access',
        ]);

        $moderatorRole = Role::create([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'description' => 'Can manage votes and view results',
        ]);

        $voterRole = Role::create([
            'name' => 'Voter',
            'slug' => 'voter',
            'description' => 'Can participate in voting',
        ]);

        // Assign all permissions to Admin
        $adminRole->permissions()->attach(Permission::all());

        // Assign specific permissions to Moderator
        $moderatorRole->permissions()->attach(
            Permission::whereIn('slug', [
                'create-votes',
                'edit-votes',
                'delete-votes',
                'view-results',
            ])->get()
        );

        // Assign specific permissions to Voter
        $voterRole->permissions()->attach(
            Permission::whereIn('slug', [
                'cast-vote',
                'view-results',
            ])->get()
        );
    }
}
