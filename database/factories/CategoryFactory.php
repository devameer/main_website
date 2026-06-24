<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $names = ['Engineering', 'Design', 'Product', 'Tutorials', 'News', 'Opinion', 'Case Studies', 'Announcements'];
        $colors = ['primary', 'success', 'warning', 'danger', 'info'];

        return [
            'name' => fake()->unique()->randomElement($names),
            'color' => fake()->randomElement($colors),
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
