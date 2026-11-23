<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded
        if (User::where('email', 'admin@example.com')->exists()) {
            $this->command->info('Admin user already exists, skipping.');
            return;
        }

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Regular User',
            'email'    => 'user@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $this->command->info('✅ Admin user seeded.');
    }
}
