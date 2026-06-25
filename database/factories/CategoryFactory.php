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
            'name' => $this->faker->unique()->randomElement($names),
            'color' => $this->faker->randomElement($colors),
            'description' => $this->faker->sentence(),
            'sort_order' => $this->faker->numberBetween(0, 20),
        ];
    }
}
