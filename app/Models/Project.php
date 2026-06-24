<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'slug', 'sort_order', 'icon', 'year', 'url',
        'name_ar', 'name_en', 'role_ar', 'role_en',
        'desc_ar', 'desc_en', 'overview_ar', 'overview_en',
        'tags_ar', 'tags_en', 'highlights_ar', 'highlights_en',
        'is_published',
    ];

    protected $casts = [
        'tags_ar' => 'array',
        'tags_en' => 'array',
        'highlights_ar' => 'array',
        'highlights_en' => 'array',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $project) {
            $project->slug ??= Str::slug($project->name_en) . '-' . Str::random(4);
            if ($project->sort_order === null || $project->sort_order === 0) {
                $project->sort_order = (int) self::max('sort_order') + 1;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    protected function localized(string $arField, string $enField): ?string
    {
        if (app()->getLocale() === 'ar') {
            return $this->$arField ?: $this->$enField;
        }

        return $this->$enField ?: $this->$arField;
    }

    public function getNameAttribute(): string
    {
        return $this->localized('name_ar', 'name_en');
    }

    public function getRoleAttribute(): ?string
    {
        return $this->localized('role_ar', 'role_en');
    }

    public function getDescAttribute(): ?string
    {
        return $this->localized('desc_ar', 'desc_en');
    }

    public function getOverviewAttribute(): ?string
    {
        return $this->localized('overview_ar', 'overview_en');
    }

    public function getTagsAttribute(): array
    {
        $value = app()->getLocale() === 'ar'
            ? ($this->tags_ar ?: $this->tags_en)
            : ($this->tags_en ?: $this->tags_ar);

        return array_values((array) $value);
    }

    public function getHighlightsAttribute(): array
    {
        $value = app()->getLocale() === 'ar'
            ? ($this->highlights_ar ?: $this->highlights_en)
            : ($this->highlights_en ?: $this->highlights_ar);

        return array_values((array) $value);
    }
}
