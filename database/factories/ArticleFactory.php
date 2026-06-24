<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Getting Started with Laravel Livewire',
            'Designing a Dashboard with Tailwind CSS',
            'Mastering Blade Components',
            'A Practical Guide to Dark Mode',
            'Building Accessible Admin Panels',
            'Optimizing Database Queries in Eloquent',
            'Modern CSS Layouts with Flexbox & Grid',
            'Understanding Alpine.js State',
            'A Deep Dive into Vite Bundling',
            'Crafting Reusable UI Patterns',
        ];
        $authors = [
            ['Ameer Ahmad', 12],
            ['Sara Khaled', 5],
            ['Omar Nasser', 32],
            ['Lina Hadi', 47],
        ];
        $author = fake()->randomElement($authors);
        $status = fake()->randomElement(['published', 'published', 'published', 'draft', 'scheduled', 'archived']);

        return [
            'title' => fake()->randomElement($titles),
            'title_en' => fn (array $a) => $a['title'],
            'body' => fake()->paragraphs(4, true),
            'body_en' => fn (array $a) => $a['body'],
            'excerpt' => fake()->sentence(),
            'language' => fake()->randomElement(['en', 'ar']),
            'cover_image' => 'https://picsum.photos/seed/' . fake()->uuid() . '/120/80',
            'author' => $author[0],
            'author_avatar' => 'https://i.pravatar.cc/64?img=' . $author[1],
            'category' => fake()->randomElement(['Engineering', 'Design', 'Product', 'Tutorials', 'News']),
            'status' => $status,
            'views' => fake()->numberBetween(0, 18500),
            'published_at' => $status === 'published' ? fake()->dateTimeBetween('-60 days', 'now') : null,
        ];
    }
}
