<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Venue::create([
            "name" => "The Conservative Club",
            "description" =>
                "Leighton Buzzard Conservative club, on the high street",
        ]);
        Venue::create([
            "name" => "Pages Park pavillion",
            "description" => "The pavillion in Pages Park",
        ]);
    }
}
