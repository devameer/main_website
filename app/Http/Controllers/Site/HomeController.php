<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles = Article::query()
            ->where('status', 'published')
            ->forLocale()
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $categories = Category::withCount(['articles' => fn ($q) => $q->where('status', 'published')->forLocale()])
            ->orderByDesc('articles_count')
            ->get()
            ->filter(fn ($c) => $c->articles_count > 0)
            ->take(8);

        return view('site.home', compact('latestArticles', 'categories'));
    }
}
