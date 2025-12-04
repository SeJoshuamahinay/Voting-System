<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@vote2voice.com',
            'password' => Hash::make('password123'),
        ]);

        // Attach Administrator role
        $adminRole = Role::where('slug', 'administrator')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        $this->command->info('Admin user created: admin@vote2voice.com / password123');
    }
}
