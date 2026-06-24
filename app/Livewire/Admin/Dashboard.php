<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\Computed;

class Dashboard extends Component
{
    #[Computed]
    public function stats(): array
    {
        return [
            'published' => Article::where('status', 'published')->count(),
            'drafts' => Article::where('status', 'draft')->count(),
            'scheduled' => Article::where('status', 'scheduled')->count(),
            'messages' => 0,
        ];
    }

    #[Computed]
    public function visitsSeries(): array
    {
        $labels = [];
        $visits = [];
        $unique = [];

        for ($i = 0; $i < 30; $i++) {
            // deterministic pseudo-random for stable demo data
            $seed = sin($i * 12.9898) * 43758.5453;
            $base = (int) (abs($seed - floor($seed)) * 4000) + 800;
            $trend = (int) ($i * 120);
            $bump = ($i % 7 === 0) ? 900 : 0;

            $labels[] = now()->subDays(29 - $i)->format('M j');
            $visits[] = $base + $trend + $bump;
            $unique[] = (int) (($base + $trend) * 0.62);
        }

        return [
            'labels' => $labels,
            'visits' => $visits,
            'unique' => $unique,
        ];
    }

    #[Computed]
    public function languageBreakdown(): array
    {
        $counts = Article::selectRaw('language, COUNT(*) as total')
            ->groupBy('language')
            ->pluck('total', 'language');

        return [
            ['label' => 'English', 'value' => $counts->get('en', 0), 'color' => '#6366f1'],
            ['label' => 'Arabic', 'value' => $counts->get('ar', 0), 'color' => '#10b981'],
        ];
    }

    #[Computed]
    public function latestArticles()
    {
        return Article::orderByDesc('id')->limit(5)->get();
    }

    #[Computed]
    public function recentMessages(): array
    {
        return [
            ['name' => 'Sarah Khaled', 'avatar' => 'https://i.pravatar.cc/64?img=5', 'preview' => 'Love the new article layout — looks super clean!', 'time' => '3m ago', 'unread' => true],
            ['name' => 'Omar Nasser', 'avatar' => 'https://i.pravatar.cc/64?img=32', 'preview' => 'Can we schedule the migration guide for next week?', 'time' => '26m ago', 'unread' => true],
            ['name' => 'Lina Hadi', 'avatar' => 'https://i.pravatar.cc/64?img=47', 'preview' => 'Found a small typo in the SEO section, fixed it 🙌', 'time' => '1h ago', 'unread' => false],
            ['name' => 'Karim Adel', 'avatar' => 'https://i.pravatar.cc/64?img=13', 'preview' => 'The dashboard charts are working great, thanks!', 'time' => '4h ago', 'unread' => false],
        ];
    }

    #[Computed]
    public function quickActions(): array
    {
        return [
            ['label' => 'New Article', 'icon' => 'plus', 'route' => route('admin.articles.create'), 'tone' => 'primary'],
            ['label' => 'Drafts', 'icon' => 'draft', 'route' => route('admin.articles.index', ['status' => 'draft']), 'tone' => 'warning'],
            ['label' => 'Published', 'icon' => 'check-circle', 'route' => route('admin.articles.index', ['status' => 'published']), 'tone' => 'success'],
            ['label' => 'All Articles', 'icon' => 'list', 'route' => route('admin.articles.index'), 'tone' => 'info'],
        ];
    }

    public function render(): mixed
    {
        return $this->page('livewire.admin.dashboard', 'Dashboard', [
            ['label' => 'Dashboard'],
        ], [
            'messagesCount' => 8,
        ]);
    }
}
