<?php

namespace Database\Factories;

use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $starts_at = fake()->dateTimeThisYear(Carbon::now()->addMonth());
        $ends_at = Carbon::parse($starts_at)->addHours(rand(1, 8));

        return [
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'venue_id' => Venue::all()->random()->id,
        ];
    }
}
