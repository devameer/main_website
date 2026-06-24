<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color', 'description', 'sort_order'];

    protected static function booted(): void
    {
        static::creating(function (self $category) {
            $category->slug ??= Str::slug($category->name) . '-' . Str::random(4);
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'category', 'name');
    }
}
