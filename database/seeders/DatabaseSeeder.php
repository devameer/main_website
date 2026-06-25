<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $team = [
            ['Ameer Ahmad', 'ameer@example.com', 'admin', 'Founder & Editor'],
            ['Sara Khaled', 'sara@example.com', 'editor', 'Content Lead'],
            ['Omar Nasser', 'omar@example.com', 'author', 'Engineering Writer'],
            ['Lina Hadi', 'lina@example.com', 'author', 'Design Writer'],
            ['Karim Adel', 'karim@example.com', 'editor', 'News Editor'],
            ['Maya Tarek', 'maya@example.com', 'viewer', 'Reader'],
        ];
        foreach ($team as $i => [$name, $email, $role, $title]) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => $role,
                'avatar' => 'https://i.pravatar.cc/64?img=' . [12, 5, 32, 47, 13, 23][$i],
                'title' => $title,
                'active' => $i !== 5,
                'email_verified_at' => now(),
            ]);
        }

        $names = [
            ['Sarah Khaled', 'sarah@example.com', 5],
            ['Omar Nasser', 'omar@example.com', 32],
            ['Lina Hadi', 'lina@example.com', 47],
            ['Karim Adel', 'karim@example.com', 13],
            ['Maya Tarek', 'maya@example.com', 23],
            ['Yusuf Said', 'yusuf@example.com', 60],
        ];
        $subjects = [
            'Question about the new article layout',
            'Collaboration opportunity',
            'Found a typo in the SEO guide',
            'Subscription cancellation request',
            'Love your content — keep it up!',
            'Partnership inquiry for Q3',
            'Bug report: charts not loading on Safari',
            'Requesting an article refund',
        ];
        $bodies = [
            'Hi there, I really enjoyed your latest piece on Livewire. Could you clarify the part about entangle() with array state? Thanks!',
            'Hello, we run a developer community and would love to feature your articles. Let me know if you are interested.',
            'Small thing — in the SEO section, "meta discription" should be "description". Great guide otherwise!',
            'I would like to cancel my monthly subscription. My email is linked to this account.',
            'Just wanted to say your dashboard series is the best I have found. Looking forward to more!',
            'We are organizing a conference and would love to have you as a speaker. Dates are flexible.',
            'The dashboard donut chart fails to render on Safari 16. Console shows a canvas error.',
            'I purchased the premium bundle but never received access. Could you assist?',
        ];

        foreach (range(1, 14) as $i) {
            $person = $names[array_rand($names)];
            $idx = array_rand($subjects);
            Message::create([
                'name' => $person[0],
                'email' => $person[1],
                'avatar' => 'https://i.pravatar.cc/64?img=' . $person[2],
                'subject' => $subjects[$idx],
                'body' => $bodies[$idx],
                'status' => $i <= 5 ? 'unread' : ($i <= 10 ? 'read' : 'archived'),
                'starred' => $i % 5 === 0,
                'read_at' => $i <= 5 ? null : now()->subHours($i),
                'created_at' => now()->subHours($i * 2),
                'updated_at' => now()->subHours($i * 2),
            ]);
        }
    }
}
