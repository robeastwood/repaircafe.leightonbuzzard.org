<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = array_keys(\App\Models\Item::statusOptions());
        $status = $this->faker->randomElement($statuses);

        return [
            'item_id' => \App\Models\Item::factory(),
            'user_id' => \App\Models\User::factory(),
            'status_orig' => $status,
            'status_new' => $status,
            'note' => $this->faker->sentence(10),
        ];
    }

    /**
     * Indicate that the note includes a status change.
     */
    public function withStatusChange(): static
    {
        return $this->state(function (array $attributes) {
            $statuses = array_keys(\App\Models\Item::statusOptions());
            $origStatus = $this->faker->randomElement($statuses);
            $newStatus = $this->faker->randomElement(array_diff($statuses, [$origStatus]));

            return [
                'status_orig' => $origStatus,
                'status_new' => $newStatus,
            ];
        });
    }
}
