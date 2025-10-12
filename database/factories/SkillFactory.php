<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Electrical Repair',
                'Computer Repair',
                'Bicycle Repair',
                'Sewing',
                'Woodwork',
                'Plumbing',
                'Gardening',
                'Painting',
                'Appliance Repair',
                'Electronics',
                'Welding',
                'Upholstery',
                'Shoe Repair',
                'Watch Repair',
                'Mobile Phone Repair',
            ]),
            'description' => fake()->sentence(),
        ];
    }
}
