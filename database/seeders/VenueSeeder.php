<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::create([
            'name' => 'The Conservative Club',
            'description' => 'Leighton Buzzard Conservative club, on the high street',
        ]);
        Venue::create([
            'name' => 'Pages Park pavillion',
            'description' => 'The pavillion in Pages Park',
        ]);
    }
}
