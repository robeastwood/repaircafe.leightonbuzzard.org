<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin user if not exists
        $adminUser = User::firstOrCreate(
            ['email' => 'test@test.com'], [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        // give admin role to admin user
        $adminUser->assignRole('admin');

        // create fixer user if not exists
        $fixerUser = User::firstOrCreate(
            ['email' => 'fixer@test.com'], [
                'name' => 'Fixer User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        // give fixer role to fixer user
        $fixerUser->assignRole('fixer');

        // create volunteer user if not exists
        $volunteerUser = User::firstOrCreate(
            ['email' => 'volunteer@test.com'], [
                'name' => 'Volunteer User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        // give volunteer role to volunteer user
        $volunteerUser->assignRole('volunteer');

        // create 10 normal users
        User::factory(10)->create();
    }
}
