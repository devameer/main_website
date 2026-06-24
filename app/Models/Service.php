<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'slug', 'sort_order', 'icon',
        'title_en', 'title_ar', 'desc_en', 'desc_ar',
        'items_en', 'items_ar', 'is_published',
    ];

    protected $casts = [
        'items_en' => 'array',
        'items_ar' => 'array',
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $service) {
            $service->slug ??= Str::slug($service->title_en) . '-' . Str::random(4);
            if ($service->sort_order === null || $service->sort_order === 0) {
                $service->sort_order = (int) self::max('sort_order') + 1;
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

    protected function localized(string $enField, string $arField): ?string
    {
        return app()->getLocale() === 'ar'
            ? ($this->$arField ?: $this->$enField)
            : ($this->$enField ?: $this->$arField);
    }

    public function getTitleAttribute(): string
    {
        return $this->localized('title_en', 'title_ar');
    }

    public function getDescAttribute(): ?string
    {
        return $this->localized('desc_en', 'desc_ar');
    }

    public function getItemsAttribute(): array
    {
        $value = app()->getLocale() === 'ar'
            ? ($this->items_ar ?: $this->items_en)
            : ($this->items_en ?: $this->items_ar);

        return array_values((array) $value);
    }
}
