<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $starts_at = fake()->dateTimeThisYear();
        $ends_at = Carbon::parse($starts_at)->addHours(rand(1,8));

        return [
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'venue_id' => Venue::all()->random()->id
        ];
    }
}
