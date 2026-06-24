<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'title_en', 'slug', 'body', 'body_en', 'excerpt',
        'language', 'cover_image', 'author', 'author_avatar', 'category',
        'status', 'meta_title', 'meta_description',
        'primary_keyword', 'secondary_keywords', 'search_intent', 'target_audience', 'reading_time',
        'views', 'published_at',
    ];

    protected $casts = [
        'views' => 'integer',
        'secondary_keywords' => 'array',
        'published_at' => 'datetime',
    ];

    public const STATUSES = ['published', 'draft', 'scheduled', 'archived'];
    public const LANGUAGES = ['en', 'ar'];

    protected static function booted(): void
    {
        static::creating(function (self $article) {
            $article->slug ??= Str::slug($article->title_en ?? $article->title) . '-' . Str::random(5);
        });
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Scope to articles written in the given (or current) language.
     */
    public function scopeForLocale(\Illuminate\Database\Eloquent\Builder $query, ?string $locale = null): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('language', $locale ?? app()->getLocale());
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Display title in the article's own language, falling back to the other.
     */
    public function getDisplayTitleAttribute(): string
    {
        if ($this->language === 'en') {
            return trim((string) $this->title_en) !== '' ? $this->title_en : ($this->title ?? '');
        }

        return trim((string) $this->title) !== '' ? $this->title : ($this->title_en ?? '');
    }
}
