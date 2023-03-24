<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::all()->random();

        return [
            "user_id" => User::all()->random()->id,
            "category_id" => $category->id,
            "status" => $this->faker->randomElement(array_keys(Item::statusOptions())),
            "description" => $this->faker->words(3, true),
            "issue" => $this->faker->paragraph(),
            "notes" => $this->faker->paragraph(),
            "powered" => $category->powered,
        ];
    }

    /**
     * Items not belonging to a registered user
     *
     * @return $this
     */
    public function annon(): static
    {
        return $this->state(function (array $attributes) {
            return [
                "user_id" => null,
            ];
        });
    }
}
