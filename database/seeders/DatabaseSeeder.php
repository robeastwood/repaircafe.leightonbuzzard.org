<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            VenueSeeder::class,
            SkillSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
            EventSeeder::class,
        ]);
    }
}
