<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaItemFactory extends Factory
{
    public function definition(): array
    {
        $names = ['cover-hero', 'team-photo', 'product-shot', 'background-gradient', 'author-portrait', 'feature-banner', 'logo-mark', 'illustration', 'screenshot-dashboard', 'pattern-texture'];
        $collections = ['articles', 'avatars', 'banners', 'default'];
        $w = fake()->randomElement([800, 1200, 1600, 1920]);
        $h = fake()->randomElement([600, 800, 900, 1080]);

        return [
            'name' => fake()->randomElement($names) . '-' . fake()->numberBetween(1, 99) . '.jpg',
            'path' => 'https://picsum.photos/seed/' . fake()->uuid() . '/' . $w . '/' . $h,
            'type' => 'image',
            'mime_type' => 'image/jpeg',
            'size' => fake()->numberBetween(80_000, 4_500_000),
            'width' => $w,
            'height' => $h,
            'collection' => fake()->randomElement($collections),
            'alt_text' => fake()->optional(0.6)->sentence(3),
            'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
        ];
    }
}
