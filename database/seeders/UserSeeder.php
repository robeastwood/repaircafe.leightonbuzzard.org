<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the factory seeds.
     *
     * @return void
     */
    public function run()
    {
        // create an admin
        User::factory()
            ->isAdmin()
            ->create(
                [
                    'name' => 'Test User',
                    'email' => 'test@test.com',
                ]
            );
        // create 100 guests
        User::factory(100)->create();

        // create 50 volunteers each with 5 random skills
        $volunteers = User::factory(50)
            ->create();
        foreach ($volunteers as $volunteer) {
            $skills = Skill::inRandomOrder()->limit(5)->get();
            $volunteer->skills()->sync($skills);
        }

    }
}
