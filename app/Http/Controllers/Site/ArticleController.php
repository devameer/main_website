<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Support\Markdown;

class ArticleController extends Controller
{
    public function index()
    {
        $category = request('category');

        $articles = Article::query()
            ->where('status', 'published')
            ->forLocale()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $featured = Article::query()
            ->where('status', 'published')
            ->forLocale()
            ->orderByDesc('views')
            ->limit(3)
            ->get();

        $categories = Category::withCount(['articles' => fn ($q) => $q->where('status', 'published')->forLocale()])
            ->orderByDesc('articles_count')
            ->get()
            ->filter(fn ($c) => $c->articles_count > 0);

        return view('site.articles.index', compact('articles', 'featured', 'categories', 'category'));
    }

    public function show(string $locale, string $slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $article->increment('views');

        $bodyField = $article->language === 'ar' ? 'body' : 'body_en';
        $bodyHtml = Markdown::toHtml((string) ($article->$bodyField ?? $article->body ?? ''));

        $related = Article::query()
            ->where('status', 'published')
            ->forLocale($article->language)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $approvedComments = $article->comments()
            ->where('status', 'approved')
            ->orderByDesc('created_at')
            ->get();

        return view('site.articles.show', compact('article', 'bodyHtml', 'related', 'approvedComments'));
    }
}
