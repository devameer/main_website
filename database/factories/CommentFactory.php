<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $commentBodies = [
            'This is incredibly helpful, thank you for the clear explanation!',
            'I have been looking for exactly this. Bookmarked.',
            'Could you write a follow-up about the advanced use cases?',
            'The dark mode toggle does not work on Firefox for me. Anyone else?',
            'Amazing work as always. The design system is beautiful.',
            'Minor nit: the spacing on mobile feels a bit tight.',
            'Finally a dashboard that does not look like every other one. Love it.',
            'How does this compare to Filament? Would love a comparison.',
            'Saved me hours today. The Livewire entangle tip was gold.',
            'Not sure I agree with the color choice for the warning state.',
        ];
        $authors = [
            ['James Carter', 11], ['Nora Ali', 16], ['Diego Ramos', 8],
            ['Mei Lin', 25], ['Tomas Berg', 14], ['Aisha Noor', 40],
            ['Ravi Patel', 51], ['Elena Voss', 9],
        ];
        $author = fake()->randomElement($authors);
        $weighted = array_merge(array_fill(0, 3, 'pending'), array_fill(0, 6, 'approved'), ['spam']);

        return [
            'article_id' => Article::inRandomOrder()->first()?->id ?? Article::factory(),
            'author_name' => $author[0],
            'author_email' => fake()->safeEmail(),
            'author_avatar' => 'https://i.pravatar.cc/64?img=' . $author[1],
            'body' => fake()->randomElement($commentBodies),
            'status' => fake()->randomElement($weighted),
            'likes' => fake()->numberBetween(0, 42),
            'ip_address' => fake()->ipv4(),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
