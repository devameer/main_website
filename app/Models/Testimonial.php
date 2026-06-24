<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'sort_order', 'initials',
        'author_en', 'author_ar', 'role_en', 'role_ar',
        'body_en', 'body_ar', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $t) {
            if ($t->sort_order === null || $t->sort_order === 0) {
                $t->sort_order = (int) self::max('sort_order') + 1;
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

    public function getAuthorAttribute(): ?string
    {
        return $this->localized('author_en', 'author_ar');
    }

    public function getRoleAttribute(): ?string
    {
        return $this->localized('role_en', 'role_ar');
    }

    public function getBodyAttribute(): string
    {
        return $this->localized('body_en', 'body_ar') ?? '';
    }
}
